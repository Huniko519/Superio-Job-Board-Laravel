<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\URL;
    use Modules\Booking\Models\Booking;
    use Modules\Candidate\Models\Candidate;
    use Modules\Company\Models\Company;
    use Modules\Gig\Models\Gig;
    use Modules\Job\Models\Job;
    use Modules\Review\Models\Review;
    use Modules\User\Emails\EmailUserVerifyRegister;
    use Modules\User\Emails\ResetPasswordToken;
    use Modules\User\Models\Plan;
    use Modules\User\Models\UserPlan;
    use Modules\User\Models\UserWishList;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\Auth;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class User extends Authenticatable implements MustVerifyEmail,JWTSubject
    {
        use SoftDeletes;
        use Notifiable;
        use \Modules\User\Traits\HasRoles;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name',
            'first_name',
            'last_name',
            'email',
            'email_verified_at',
            'password',
            'address',
            'address2',
            'phone',
            'birthday',
            'city',
            'state',
            'country',
            'zip_code',
            'last_login_at',
            'avatar_id',
            'bio',
            'business_name',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

        protected $attributes = [
            'status'=>'publish'
        ];

        public function getMeta($key, $default = '')
        {
            $val = DB::table('user_meta')->where([
                'user_id' => $this->id,
                'name'    => $key
            ])->first();

            if (!empty($val)) {
                return $val->val;
            }

            return $default;
        }

        public function addMeta($key, $val, $multiple = false)
        {
            if(is_array($val) or is_object($val)) $val = json_encode($val);
            if ($multiple) {
                return DB::table('user_meta')->insert([
                    'name'    => $key,
                    'val'     => $val,
                    'user_id' => $this->id,
                    'create_user'=>Auth::id(),
                    'created_at'=>date('Y-m-d H:i:s')
                ]);
            } else {
                $old = DB::table('user_meta')->where([
                    'user_id' => $this->id,
                    'name'    => $key
                ])->first();

                if ($old) {
                    return DB::table('user_meta')->where('id', $old->id)->update([
                        'val' => $val,
                        'update_user'=>Auth::id(),
                        'updated_at'=>date('Y-m-d H:i:s')
                    ]);
                } else {
                    return DB::table('user_meta')->insert([
                        'name'    => $key,
                        'val'     => $val,
                        'user_id' => $this->id,
                        'create_user'=>Auth::id(),
                        'created_at'=>date('Y-m-d H:i:s')
                    ]);
                }
            }

        }

        public function updateMeta($key,$val){

            return DB::table('user_meta')->where('user_id', $this->id)
                ->where('name', $key)
                ->update([
                'val' => $val,
                'update_user'=>Auth::id(),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        }

        public function batchInsertMeta($metaArrs = [])
        {
            if (!empty($metaArrs)) {
                foreach ($metaArrs as $key => $val) {
                    $this->addMeta($key, $val, true);
                }
            }
        }

        public function getNameOrEmailAttribute()
        {
            if ($this->first_name) return $this->first_name;

            return $this->email;
        }


        public function getStatusTextAttribute()
        {
            switch ($this->status) {
                case "publish":
                    return __("Publish");
                    break;
                case "blocked":
                    return __("Blocked");
                    break;
            }
        }

        public static function getUserBySocialId($provider, $socialId)
        {
            return parent::query()->select('users.*')->join('user_meta as m', 'm.user_id', 'users.id')
                ->where('m.name', 'social_' . $provider . '_id')
                ->where('m.val', $socialId)->first();
        }

        public function getAvatarUrl()
        {
            if (!empty($this->avatar_id)) {
                return get_file_url($this->avatar_id, 'thumb');
            }
            if(!empty($meta_avatar = $this->getMeta("social_meta_avatar",false))) {
                return $meta_avatar;
            }
            return asset('images/avatar.png');
        }
        public function getUserAvatar($default_type = 'image'){
            $display_name = $this->getDisplayName();
            if (!empty($this->avatar_id)) {
                return '<img src="'.get_file_url($this->avatar_id, 'thumb').'" alt="'.$display_name.'">';
            }
            if(!empty($meta_avatar = $this->getMeta("social_meta_avatar",false))) {
                return '<img src="'.$meta_avatar.'" alt="'.$display_name.'">';
            }
            if($default_type == 'text'){
                return '<span class="user-text">'.trim($display_name)[0].'</span>';
            }
            return '<img src="'.asset('images/avatar.png').'" alt="'.$display_name.'">';
        }
        public function getAvatarUrlAttribute()
        {
            return $this->getAvatarUrl();
        }

        public function getDisplayName($email = false)
        {
            $name = $this->name??"";
            if (!empty($this->first_name) or !empty($this->last_name)) {
                $name = implode(' ', [$this->first_name, $this->last_name]);
            }
            if( !empty($this->business_name) ){
                $name  = $this->business_name;
            }
            if(!trim($name) and $email) $name = $this->email;
            if(empty($name)){
               $name = ' ';
            }
            return $name;
        }

        public function getDisplayNameAttribute()
        {
            $name = $this->name;
            if (!empty($this->first_name) or !empty($this->last_name)) {
                $name = implode(' ', [$this->first_name, $this->last_name]);
            }
            if( !empty($this->business_name) ){
                $name  = $this->business_name;
            }
            return $name;
        }

        public function sendPasswordResetNotification($token)
        {
            Mail::to($this->email)->send(new ResetPasswordToken($token,$this));
        }

        public static function boot()
        {
            parent::boot();
            static::saving(function ($table) {
                $table->name = implode(' ', [$table->first_name, $table->last_name]);
            });
        }

        public function getVendorServicesQuery($moduleClass,$limit = 10){
            return $moduleClass::getVendorServicesQuery()->take($limit);
        }

        public function getReviewCountAttribute(){
            return Review::query()->where('vendor_id',$this->id)->where('status','approved')->count('id');
        }
        public function vendorRequest(){
            return $this->hasOne(VendorRequest::class);
        }

        public function getPayoutAccountsAttribute(){
            return json_decode($this->getMeta('vendor_payout_accounts'));
        }

        /**
         * Get total available amount for payout at current time
         */
        public function getAvailablePayoutAmountAttribute(){
            $status = setting_item_array('vendor_payout_booking_status');
            if(empty($status)) return 0;

            $query = Booking::query();

            $total =  $query
                ->whereIn('status',$status)
                ->where('vendor_id',$this->id)
                ->sum(DB::raw('total_before_fees - commission + vendor_service_fee_amount')) - $this->total_paid;
            return max(0,$total);
        }

        public function getTotalPaidAttribute(){
            return VendorPayout::query()->where('status','!=','rejected')->where([
                'vendor_id'=>$this->id
            ])->sum('amount');
        }

        public function getAvailablePayoutMethodsAttribute()
        {
            $vendor_payout_methods = json_decode(setting_item('vendor_payout_methods'));
            if(!is_array($vendor_payout_methods)) $vendor_payout_methods = [];

            $vendor_payout_methods = array_values(\Illuminate\Support\Arr::sort($vendor_payout_methods, function ($value) {
                return $value->order ?? 0;
            }));

            $res = [];

            $accounts = $this->payout_accounts;

            if(!empty($vendor_payout_methods) and !empty($accounts))
            {
                foreach ($vendor_payout_methods as $vendor_payout_method) {
                    $id = $vendor_payout_method->id;

                    if(!empty($accounts->$id))
                    {
                        $vendor_payout_method->user = $accounts->$id;
                        $res[$id] = $vendor_payout_method;
                    }
                }
            }

            return $res;
        }


        /**
         * @todo get All Fields That you need to verification
         * @return array
         */
        public function getVerificationFieldsAttribute(){

            $all = get_all_verify_fields();
            $role_id = $this->role_id;
            $res = [];
            foreach ($all as $id=>$field)
            {
                if(!empty($field['roles']) and is_array($field['roles']) and in_array($role_id,$field['roles']))
                {
                    $field['id'] = $id;
                    $field['field_id'] = 'verify_data_'.$id;
                    $field['is_verified'] = $this->isVerifiedField($id);
                    $field['data'] = old('verify_data_'.$id,$this->getVerifyData($id));

                    switch ($field['type'])
                    {
                        case "multi_files":
                            $field['data'] = json_decode($field['data'],true);
                            if(!empty($field['data']))
                            {
                                foreach ($field['data'] as $k=>$v){
                                    if(!is_array($v)){
                                        $field['data'][$k] = json_decode($v,true);
                                    }
                                }
                            }
                            break;
                    }
                    $res[$id] = $field;
                }
            }

            return \Illuminate\Support\Arr::sort($res, function ($value) {
                return $value['order'] ?? 0;
            });

        }

        public function isVerifiedField($field_id){
            return (bool) $this->getMeta('is_verified_'.$field_id);
        }
        public function getVerifyData($field_id){
            return $this->getMeta('verify_data_'.$field_id);
        }

        public static function countVerifyRequest(){
            return parent::query()->whereIn('verify_submit_status',['new','partial'])->count(['id']);
        }

        public static function countUpgradeRequest(){
            return parent::query()->whereIn('verify_submit_status',['new','partial'])->count(['id']);
        }

        public function sendEmailVerificationNotification(){
        	$actionUrl = $this->verificationUrl();
	        $a  = Mail::to($this->email)->send(new EmailUserVerifyRegister($this, $actionUrl));
        }


        public function verificationUrl(){
	        return URL::temporarySignedRoute(
		        'verification.verify',
		        Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
		        ['id' => $this->id,
                 'hash' => sha1($this->getEmailForVerification()),
                ]
	        );
        }

        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        /**
         * Return a key value array, containing any custom claims to be added to the JWT.
         *
         * @return array
         */
        public function getJWTCustomClaims()
        {
            return [];
        }

        public function creditPaymentUpdate($payment){

            if($payment->status == 'completed'){
                $this->deposit($payment->getMeta('credit'),$payment->getMeta());
            }
        }

        public function getNameAttribute(){
            return $this->first_name.' '.$this->last_name;
        }

        public function company(){
            return $this->hasOne(Company::class, 'owner_id', 'id');
        }

        public function candidate(){
            return $this->hasOne(Candidate::class, 'id', 'id');
        }

        public function fillByAttr($attributes , $input)
        {
            if(!empty($attributes)){
                foreach ( $attributes as $item ){
                    $this->$item = isset($input[$item]) ? ($input[$item]) : null;
                }
            }
        }

        public function getWishlistCountAttribute(){
            return UserWishList::query()->where('user_id',$this->id)->count('id');
        }

        public function getDetailUrl(){
            return route('user.profile',['id'=>$this->user_name ? $this->user_name : $this->id]);
        }

        public function user_plan(){
            return $this->hasOne(UserPlan::class,'id');
        }

        public function checkJobPlan(){
            if(!setting_item('job_require_plan')) return true;

            $user_plan = $this->user_plan;

            if(!$user_plan) return false;

            if($user_plan->end_date->timestamp <= time()) return false;

            if(!$this->company) return false;

            $count_service = $this->company->jobs()->count('id');

            if($user_plan->max_service and $count_service >= $user_plan->max_service){
                return false;
            }
            return true;
        }

        public function checkJobPostingMaximum(){
            $max_jobs = setting_item('job_company_max_post_jobs');
            if (!$max_jobs || setting_item('job_require_plan')) return true;

            $count_service = $this->company->jobs()->count('id');
            if($count_service >= $max_jobs){
                return false;
            }
            return true;
        }

        public function checkGigPostingMaximum(){
            $max_gigs = setting_item('gig_max_posts');
            if (!$max_gigs) return true;

            $count_service = $this->gigs->count('id');
            if($count_service >= $max_gigs){
                return false;
            }
            return true;
        }

        public function gigs(){
            return $this->hasMany(Gig::class,'author_id','id');
        }

        public function applyPlan(Plan $plan,$price,$is_annual = false){
            $user_plan = $this->user_plan;
            $max_service = $plan->max_service;
//            if(!$user_plan){
//                $user_plan = new UserPlan();
//                $user_plan->id = $this->id;
//            }else{
//                if(setting_item_with_lang('enable_multi_user_plans'))
//                {
//                    $max_service  += $user_plan->max_service;
//                }
//            }
            $user_plan = new UserPlan();

            if($is_annual){
                $end_date = strtotime('+ 1 year');
            }else{
                $end_date = strtotime('+ '.$plan->duration.' '.$plan->duration_type);
            }
            $plan_data = $plan->toArray();
            $plan_data['is_annual'] = $is_annual;
            $data = [
                'plan_id'=>$plan->id,
                'price'=>$price,
                'start_date'=>date('Y-m-d H:i:s'),
                'end_date'=>date('Y-m-d H:i:s',$end_date),
                'max_service'=>$max_service,
                'plan_data'=>$plan_data,
                'status'=>1
            ];
            $user_plan->fillByAttr(array_keys($data),$data);
            $user_plan->save();
        }
    }

