<?php
namespace Modules\Candidate\Models;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\SEO;
use Modules\Job\Models\JobCandidate;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;
use Modules\Skill\Models\Skill;
use Modules\User\Models\UserViews;
use Modules\User\Models\UserWishList;

class Candidate extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_candidates';
    protected $fillable = [
        'title',
        'content',
        'cat_id',
        'avatar_id',
        'full_name',
        'email',
        'address',
        'address2',
        'phone',
        'birthday',
        'city',
        'state',
        'country',
        'zip_code',
        'bio',
        'education',
        'experience',
        'award',
        'social_media',
        'gallery',
        'video',
        'expected_salary',
        'salary_type',
        'website',
        'allow_search',
        'video_cover_id'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'candidate';
    public $type = 'candidate';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'education' => 'array',
        'experience' => 'array',
        'award' => 'array',
        'social_media' => 'array',
        'expected_salary'=>'float'
    ];


    public function getDetailUrlAttribute()
    {
        return url('candidate-' . $this->slug);
    }

    public function geCategorylink()
    {
        return route('candidate.category.index',['slug'=>$this->slug]);
    }

    public function cat()
    {
        return $this->belongsTo('Modules\Candidate\Models\Category');
    }

    public function cvs()
    {
        return $this->hasMany(CandidateCvs::class,'origin_id');
    }

    public function location(){
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public static function getAll()
    {
        return self::with('cat')->get();
    }

    public function getDetailUrl($locale = false)
    {
        return url(app_get_locale(false,false,'/'). config('candidate.candidate_route_prefix')."/".$this->slug);
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'bc_candidate_skills', 'origin_id', 'skill_id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'bc_candidate_categories', 'origin_id', 'cat_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'id','id');
    }

    public function check_maximum_apply_job(){
        $maximum = setting_item('candidate_maximum_job_apply', '');
        if (!empty($maximum)){
            $candidate_limit_apply_by = setting_item('candidate_limit_apply_by', '');
            $job_candidates = JobCandidate::query()->where('candidate_id', $this->id);
            switch ($candidate_limit_apply_by){
                case 'day':
                    $today = date('Y-m-d 00:00:00');
                    $job_candidates = $job_candidates->where('created_at', '>=', $today)->groupBy('job_id')->get()->count();
                    if((int)$maximum <= $job_candidates ){
                        return ['mess' => 'Your turns to apply for job positions (to day) have run out'];
                    }
                    break;
                case 'month':
                    $this_month = date('Y-m-01 00:00:00');
                    $job_candidates = $job_candidates->where('created_at', '>=', $this_month)->groupBy('job_id')->get()->count();
                    if((int)$maximum <= $job_candidates ){
                        return ['mess' => 'Your turns to apply for job positions (this month) have run out'];
                    }
                    break;
                default:
                    $job_candidates = $job_candidates->groupBy('job_id')->get()->count();
                    if((int)$maximum <= $job_candidates ){
                        return ['mess' => 'Your turns to apply for job positions have run out'];
                    }
                    break;
            }


        }
        return false;
    }

    public function getCategory()
    {
        $categories = [];
        if(!empty($this->cat_id)){
            $catSearch = explode(',', $this->cat_id);
            $categories = Category::whereIn('id', $catSearch)->get();
        }
        return $categories;
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if (strlen($q)) {

            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = setting_item_with_lang("candidate_page_list_seo_title", false, setting_item_with_lang("candidate_page_search_title",false, __("Candidates")));
        $meta['seo_desc'] = setting_item_with_lang("candidate_page_list_seo_desc");
        $meta['seo_image'] = setting_item("candidate_page_list_seo_image", null);
        $meta['seo_share'] = setting_item_with_lang("candidate_page_list_seo_share");
        $meta['full_url'] = url(config('candidate.candidate_route_prefix'));
        return $meta;
    }

    public function getEditUrl()
    {
        $lang = $this->lang ?? setting_item("site_locale");
        return route('user.admin.detail',['id'=>$this->id, "lang"=> $lang]);
    }

    public function dataForApi($forSingle = false){
        $translation = $this->translateOrOrigin(app()->getLocale());
        $data = [
            'id'=>$this->id,
            'slug'=>$this->slug,
            'title'=>$translation->title,
            'content'=>$translation->content,
            'avatar_id'=>$this->avatar_id,
            'image_url'=>get_file_url($this->avatar_id,'full'),
            'category'=>Category::selectRaw("id,name,slug")->find($this->cat_id) ?? null,
            'created_at'=>display_date($this->created_at),
            'author'=>[
                'display_name'=>$this->getAuthor->getDisplayName(),
                'avatar_url'=>$this->getAuthor->getAvatarUrl()
            ],
            'url'=>$this->getDetailUrl()
        ];
        return $data;
    }
    public function getGallery($featuredIncluded = false)
    {
        if (empty($this->gallery))
            return $this->gallery;
        $list_item = [];
        if ($featuredIncluded and $this->image_id) {
            $list_item[] = [
                'large' => FileHelper::url($this->image_id, 'full'),
                'thumb' => FileHelper::url($this->image_id, 'thumb')
            ];
        }
        $items = explode(",", $this->gallery);
        foreach ($items as $k => $item) {
            $large = FileHelper::url($item, 'full');
            $thumb = FileHelper::url($item, 'thumb');
            $list_item[] = [
                'large' => $large,
                'thumb' => $thumb
            ];
        }
        return $list_item;
    }

    public function getImageUrl($size = "medium", $img = '')
    {
        $s_image = (!empty($img)) ? $img : $this->image_id;
        $url = FileHelper::url($s_image, $size);
        return $url ? $url : '';
    }

    public static function getMinMaxPrice()
    {
        $model = parent::selectRaw('MIN( expected_salary ) AS min_price ,
                                    MAX( expected_salary ) AS max_price ')->where("allow_search", "publish")->first();
        if (empty($model->min_price) and empty($model->max_price)) {
            return [
                0,
                100
            ];
        }
        return [
            $model->min_price,
            $model->max_price
        ];
    }

    public static function search(Request $request)
    {
        $model_candidate = parent::query()->select("bc_candidates.*");
        $model_candidate->where("bc_candidates.allow_search", "publish");

        if (!empty($location_id = $request->query('location'))) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $model_candidate->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_candidates.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }

        if (!empty($skill = $request->query('skill'))) {
            if(!empty($skill)){
                $model_candidate->join('bc_candidate_skills', function ($join) use ($skill) {
                    $join->on('bc_candidate_skills.origin_id', '=', 'bc_candidates.id')
                        ->where('bc_candidate_skills.skill_id', '=', $skill);
                });
            }
        }

        if (!empty($category = $request->query('category'))) {
            if(!empty($category)){
                $model_candidate->join('bc_candidate_categories', function ($join) use ($category) {
                    $join->on('bc_candidate_categories.origin_id', '=', 'bc_candidates.id')
                        ->where('bc_candidate_categories.cat_id', '=', $category);
                });
            }
        }

        if (!empty($date_posted = $request->query('date_posted'))) {
            switch($date_posted){
                case 'last_hour':
                    $date_p = date('Y-m-d H:i:s', strtotime('-1 hour'));
                    break;
                case 'last_1':
                    $date_p = date('Y-m-d H:i:s', strtotime("-1 day"));
                    break;
                case 'last_7':
                    $date_p = date('Y-m-d H:i:s', strtotime("-1 week"));
                    break;
                case 'last_14':
                    $date_p = date('Y-m-d H:i:s', strtotime("-2 weeks"));
                    break;
                case 'last_30':
                    $date_p = date('Y-m-d H:i:s', strtotime("-1 month"));
                    break;
            }
            if(!empty($date_p)) {
                $model_candidate->where('bc_candidates.created_at', '>=', $date_p);
            }
        }

        if (!empty($experiences = $request->query('experience_year'))) {
            $model_candidate->where(function ($query) use ($experiences){
                if (!empty($experiences)){
                    if(is_array($experiences)){
                        foreach ($experiences as $key => $exp){
                            if($exp == 'fresh') {
                                $exp = 0;
                            }
                            $exp = (int)$exp;
                            if ($key == 0) {
                                $query->where([
                                    ['experience_year', '>=' , $exp],
                                    ['experience_year', '<' , $exp + 1]
                                ]);
                            } else {
                                $query->orWhere([
                                    ['experience_year', '>=' , $exp],
                                    ['experience_year', '<' , $exp + 1]
                                ]);
                            }
                        }
                    }else{
                        $exp = (int)($experiences == 'fresh' ? 0 : $experiences);
                        $query->where([
                            ['experience_year', '>=' , $exp],
                            ['experience_year', '<' , $exp + 1]
                        ]);
                    }

                }
            });
        }

        if (!empty($education_level = $request->query('education_level'))) {
            $model_candidate->where(function ($query) use ($education_level){
                if (!empty($education_level)){
                    if(is_array($education_level)){
                        foreach ($education_level as $key => $level){
                            if ($key == 0) {
                                $query->where('education_level', $level);
                            } else {
                                $query->orWhere('education_level', $level);
                            }
                        }
                    }else{
                        $query->where('education_level', $education_level);
                    }
                }
            });
        }


        if(!empty( $candidate_name = $request->query("s") )){
            $model_candidate->leftJoin('users', function ($join) {
                $join->on('bc_candidates.id', '=', 'users.id');
            });
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $model_candidate->leftJoin('bc_candidate_translations', function ($join) {
                    $join->on('bc_candidates.id', '=', 'bc_candidate_translations.origin_id');
                });
                $model_candidate->where('bc_candidate_translations.title', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.first_name', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.last_name', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('bc_candidates.title', 'LIKE', '%' . $candidate_name . '%');
            }else{
                $model_candidate->where('bc_candidates.title', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.first_name', 'LIKE', '%' . $candidate_name . '%')
                    ->orWhere('users.last_name', 'LIKE', '%' . $candidate_name . '%');
            }


        }

        if(!empty($orderby = $request->query("orderby"))) {
            switch($orderby) {
                case"new":
                    $model_candidate->orderBy("id", "desc");
                    break;
                case"old":
                    $model_candidate->orderBy("id", "asc");
                    break;
                case"name_high":
                    $model_candidate->orderBy("title", "asc");
                    break;
                case"name_low":
                    $model_candidate->orderBy("title", "desc");
                    break;
                default:
                    $model_candidate->orderBy("id", "desc");
                    break;
            }
        }else{
            $model_candidate->orderBy("id", "desc");
        }

        $model_candidate->groupBy("bc_candidates.id");

        $model_candidate->whereNotNull('title');

        $limit = $request->query('limit',10);
        return $model_candidate->with(['translations', 'wishlist', 'user', 'categories'])->paginate($limit);
    }

    public function timeAgo() {
        if(empty($this->created_at)) return false;
        $estimate_time = strtotime('now') - strtotime($this->created_at);

        if( $estimate_time < 1 )
        {
            return false;
        }
        if(($estimate_time/86400) >= 1){
            return display_date($this->created_at);
        }
        $condition = array(
            60 * 60                 =>  __('hour(s) ago'),
            60                      =>  __('minute(s) ago'),
            1                       =>  __('second(s) ago'),
        );
        foreach( $condition as $secs => $str ){
            $d = $estimate_time / $secs;

            if( $d >= 1 ){
                if($d < 60 && $secs == 1){
                    return __("just now");
                }
                $r = round( $d );
                return $r . ' ' . $str;
            }
        }
        return display_date($this->created_at);
    }

    /*public static function getTopCardsReport()
    {
        $userId = Auth::id();
        if (empty($userId)) redirect()->to('login');
        $applied_job_total = JobCandidate::where('candidate_id',$userId)->where('status','approved')->count();
        $totalMessages = \Modules\Core\Models\NotificationPush::query()->where('notifiable_id', $userId)->count();
        $totalBookmark = UserWishList::where('user_id',$userId)->count();

        $res[] = [
            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Jobs"),
            'amount' => $applied_job_total,
            'desc'   => __("Applied Jobs"),
            'class'  => 'purple',
            'icon'   => 'icon ion-ios-briefcase'
        ];
        $res[] = [

            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Messages"),
            'amount' => $totalMessages,
            'desc'   => __("Total Messages"),
            'class'  => 'info',
            'icon'   => 'icon ion-md-chatboxes'
        ];
        $res[] = [

            'size'   => 6,
            'size_md'=>3,
            'title'  => __("Bookmark"),
            'amount' => $totalBookmark,
            'desc'   => __("Total Bookmark"),
            'class'  => 'success',
            'icon'   => 'icon ion-ios-heart'
        ];
        return $res;
    }*/

    /*public static function getNotifications($limit = 10){
        $userId = Auth::id();
        if (empty($userId)) redirect()->to('login');
        $notifications = \Modules\Core\Models\NotificationPush::query()->where('data','like','%\"for_admin\":0%')->where('notifiable_id', $userId)->limit($limit)->get();
        if (empty($notifications)) return false;
        return $notifications;
    }*/

    /*public static function getDashboardChartData($from, $to){
        $data = [
            'labels'   => [],
            'datasets' => [
                [
                    'label' => "Views",
                    'backgroundColor' => 'transparent',
                    'borderColor' => '#1967D2',
                    'borderWidth' => "1",
                    'data' => [],
                    'pointRadius' => 3,
                    'pointHoverRadius' => 3,
                    'pointHitRadius' => 10,
                    'pointBackgroundColor' => "#1967D2",
                    'pointHoverBackgroundColor' => "#1967D2",
                    'pointBorderWidth' => "2"
                ]
            ]
        ];
        if (($to - $from) / DAY_IN_SECONDS > 90) {
            $year = date("Y", $from);
            // Report By Month
            for ($month = 1; $month <= 12; $month++) {
                $day_last_month = date("t", strtotime($year . "-" . $month . "-01"));
                $views = UserViews::where('user_id',Auth::id())->whereBetween('created_at', [
                    $year . '-' . $month . '-01 00:00:00',
                    $year . '-' . $month . '-' . $day_last_month . ' 23:59:59'
                ])->count();
                $data['labels'][] = date("F", strtotime($year . "-" . $month . "-01"));
                $data['datasets'][0]['data'][] = $views;
            }
        } elseif (($to - $from) <= DAY_IN_SECONDS) {
            // Report By Hours
            for ($i = strtotime(date('Y-m-d 00:00:00', $from)); $i <= strtotime(date('Y-m-d 23:59:59', $to)); $i += HOUR_IN_SECONDS) {
                $views = UserViews::where('user_id',Auth::id())->whereBetween('created_at', [
                    date('Y-m-d H:i:s', $i),
                    date('Y-m-d H:i:s', $i + HOUR_IN_SECONDS),
                ])->count();
                $data['labels'][] = date('H:i', $i);
                $data['datasets'][0]['data'][] = $views;
            }
        } else {
            for ($i = strtotime(date('Y-m-d', $from)); $i <= strtotime(date('Y-m-d 23:59:59', $to)); $i += DAY_IN_SECONDS) {
                $views = UserViews::where('user_id',Auth::id())->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', $i),
                    date('Y-m-d 23:59:59', $i),
                ])->count();
                $data['labels'][] = display_date($i);
                $data['datasets'][0]['data'][] = $views;
            }
        }

        return $data;
    }*/
}
