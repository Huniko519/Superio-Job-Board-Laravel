<?php

namespace Modules\Gig\Models;

use App\Currency;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingTimeSlots;
use Modules\Core\Models\Attributes;
use Modules\Core\Models\SEO;
use Modules\Core\Models\Terms;
use Modules\Gig\Emails\GigOrderEmail;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;
use Modules\News\Models\Tag;
use Modules\Order\Helpers\CartManager;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Gig\Models\GigTranslation;
use Modules\User\Models\UserWishList;

class Gig extends Bookable
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'bc_gigs';
    public $type = 'gig';

    protected $fillable = [
        'title',
        'content',
        'status',
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'gig';
    protected $casts = [
        'packages'         => 'array',
        'extra_price'  => 'array',
        'package_compare'  => 'array',
        'requirements'  => 'array',
        'faqs'  => 'array',
    ];
    protected $bookingClass;
    protected $bookingTimeSlotsClass;
    protected $reviewClass;
    protected $gigDateClass;
    protected $gigTermClass;
    protected $gigTranslationClass;
    protected $userWishListClass;
    protected $locationClass;


    protected $attributes = [
        'status'=>'draft'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->bookingClass = Booking::class;
        $this->bookingTimeSlotsClass = BookingTimeSlots::class;
        $this->reviewClass = Review::class;
        $this->gigTermClass = GigTerm::class;
        $this->gigTranslationClass = GigTranslation::class;
        $this->userWishListClass = UserWishList::class;
        $this->locationClass = Location::class;
    }

    public static function getModelName()
    {
        return __("Gig");
    }

    public static function getTableName()
    {
        return with(new static)->table;
    }

    /**
     * Get SEO fop page list
     *
     * @return mixed
     */
    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = __("Search for Gigs");
        if (!empty($title = setting_item_with_lang("gig_page_list_seo_title",false))) {
            $meta['seo_title'] = $title;
        }else if(!empty($title = setting_item_with_lang("gig_page_search_title"))) {
            $meta['seo_title'] = $title;
        }
        $meta['seo_image'] = null;
        if (!empty($title = setting_item("gig_page_list_seo_image"))) {
            $meta['seo_image'] = $title;
        }else if(!empty($title = setting_item("gig_page_search_banner"))) {
            $meta['seo_image'] = $title;
        }
        $meta['seo_desc'] = setting_item_with_lang("gig_page_list_seo_desc");
        $meta['seo_share'] = setting_item_with_lang("gig_page_list_seo_share");
        $meta['full_url'] = url(env('GIG_ROUTE_PREFIX','gig'));
        return $meta;
    }

    public function terms(){
        return $this->hasMany($this->gigTermClass, "target_id");
    }

    public function getDetailUrl($include_param = true)
    {
        $param = [];
        if($include_param){
            if(!empty($date =  request()->input('date'))){
                $dates = explode(" - ",$date);
                if(!empty($dates)){
                    $param['start'] = $dates[0] ?? "";
                    $param['end'] = $dates[1] ?? "";
                }
            }
            if(!empty($adults =  request()->input('adults'))){
                $param['adults'] = $adults;
            }
            if(!empty($children =  request()->input('children'))){
                $param['children'] = $children;
            }
        }
        $urlDetail = app_get_locale(false, false, '/') . env('GIG_ROUTE_PREFIX','gig') . "/" . $this->slug;
        if(!empty($param)){
            $urlDetail .= "?".http_build_query($param);
        }
        return url($urlDetail);
    }

    public static function getLinkForPageSearch( $locale = false , $param = [] ){

        return url(app_get_locale(false , false , '/'). env('GIG_ROUTE_PREFIX','gig')."?".http_build_query($param));
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

    public function getEditUrl()
    {
        return url(route('gig.admin.edit',['id'=>$this->id]));
    }

    public function getDiscountPercentAttribute()
    {
        if (    !empty($this->price) and $this->price > 0
            and !empty($this->sale_price) and $this->sale_price > 0
            and $this->price > $this->sale_price
        ) {
            $percent = 100 - ceil($this->sale_price / ($this->price / 100));
            return $percent . "%";
        }
    }

    public function fill(array $attributes)
    {
        if(!empty($attributes)){
            foreach ( $this->fillable as $item ){
                $attributes[$item] = $attributes[$item] ?? null;
            }
        }
        return parent::fill($attributes); // TODO: Change the autogenerated stub
    }

    public function isBookable()
    {
        if ($this->status != 'publish')
            return false;
        return parent::isBookable();
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

    public static function getMinMaxPrice()
    {
        $model = parent::selectRaw('MIN( basic_price ) AS min_price ,
                                    MAX( basic_price ) AS max_price ')->where("status", "publish")->first();
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

    public function getReviewEnable()
    {
        return setting_item("gig_enable_review", 0);
    }

    public function getReviewApproved()
    {
        return setting_item("gig_review_approved", 0);
    }

    public static function getReviewStats()
    {
        $reviewStats = [];
        if (!empty($list = setting_item("gig_review_stats", []))) {
            $list = json_decode($list, true);
            foreach ($list as $item) {
                $reviewStats[] = $item['title'];
            }
        }
        return $reviewStats;
    }

    public function getReviewDataAttribute()
    {
        $list_score = [
            'score_total'  => 0,
            'score_text'   => __("Not rated"),
            'total_review' => 0,
            'rate_score'   => [],
        ];
        $dataTotalReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first();
        if (!empty($dataTotalReview->score_total)) {
            $list_score['score_total'] = number_format($dataTotalReview->score_total, 1);
            $list_score['score_text'] = Review::getDisplayTextScoreByLever(round($list_score['score_total']));
        }
        if (!empty($dataTotalReview->total_review)) {
            $list_score['total_review'] = $dataTotalReview->total_review;
        }
        $list_data_rate = $this->reviewClass::selectRaw('COUNT( CASE WHEN rate_number = 5 THEN rate_number ELSE NULL END ) AS rate_5,
                                                            COUNT( CASE WHEN rate_number = 4 THEN rate_number ELSE NULL END ) AS rate_4,
                                                            COUNT( CASE WHEN rate_number = 3 THEN rate_number ELSE NULL END ) AS rate_3,
                                                            COUNT( CASE WHEN rate_number = 2 THEN rate_number ELSE NULL END ) AS rate_2,
                                                            COUNT( CASE WHEN rate_number = 1 THEN rate_number ELSE NULL END ) AS rate_1 ')->where('object_id', $this->id)->where('object_model', $this->type)->where("status", "approved")->first()->toArray();
        for ($rate = 5; $rate >= 1; $rate--) {
            if (!empty($number = $list_data_rate['rate_' . $rate])) {
                $percent = ($number / $list_score['total_review']) * 100;
            } else {
                $percent = 0;
            }
            $list_score['rate_score'][$rate] = [
                'title'   => $this->reviewClass::getDisplayTextScoreByLever($rate),
                'total'   => $number,
                'percent' => round($percent),
            ];
        }
        return $list_score;
    }

    public function getScoreReview()
    {
        $gig_id = $this->id;
        $list_score = Cache::rememberForever('review_'.$this->type.'_' . $gig_id, function () use ($gig_id) {
            $dataReview = $this->reviewClass::selectRaw(" AVG(rate_number) as score_total , COUNT(id) as total_review ")->where('object_id', $gig_id)->where('object_model', $this->type)->where("status", "approved")->first();
            $score_total = !empty($dataReview->score_total) ? number_format($dataReview->score_total, 1) : 0;
            return [
                'score_total'  => $score_total,
                'total_review' => !empty($dataReview->total_review) ? $dataReview->total_review : 0,
            ];
        });
        $list_score['review_text'] =  $list_score['score_total'] ? Review::getDisplayTextScoreByLever( round( $list_score['score_total'] )) : __("Not rated");
        return $list_score;
    }

    public function getNumberReviewsInService($status = false)
    {
        return $this->reviewClass::countReviewByServiceID($this->id, false, $status,$this->type) ?? 0;
    }

    public function getReviewList(){
        return $this->reviewClass::select(['id','title','content','rate_number','author_ip','status','created_at','vendor_id','create_user'])->where('object_id', $this->id)->where('object_model', 'gig')->where("status", "approved")->orderBy("id", "desc")->with('author')->paginate(setting_item('gig_review_number_per_page', 5));
    }


    public function getNumberServiceInLocation($location)
    {
        $number = 0;
        if(!empty($location)) {
            $number = parent::join('bc_locations', function ($join) use ($location) {
                $join->on('bc_locations.id', '=', $this->table.'.location_id')->where('bc_locations._lft', '>=', $location->_lft)->where('bc_locations._rgt', '<=', $location->_rgt);
            })->where($this->table.".status", "publish")->with(['translations'])->count($this->table.".id");
        }
        if(empty($number)) return false;
        if ($number > 1) {
            return __(":number Gigs", ['number' => $number]);
        }
        return __(":number Gig", ['number' => $number]);
    }

    public function hasWishList(){
        return $this->hasOne($this->userWishListClass, 'object_id','id')->where('object_model' , $this->type)->where('user_id' , Auth::id() ?? 0);
    }

    public function isWishList()
    {
        if(Auth::id()){
            if(!empty($this->hasWishList) and !empty($this->hasWishList->id)){
                return 'active';
            }
        }
        return '';
    }

    public static function getServiceIconFeatured(){
        return "flaticon-climbing";
    }

    public static function isEnable(){
        return setting_item('gig_disable') == false;
    }

    public function isDepositEnable(){
        return (setting_item('gig_deposit_enable') and setting_item('gig_deposit_amount'));
    }
    public function getDepositAmount(){
        return setting_item('gig_deposit_amount');
    }
    public function getDepositType(){
        return setting_item('gig_deposit_type');
    }
    public function getDepositFomular(){
        return setting_item('gig_deposit_fomular','default');
    }


    public static function search($filters = [])
    {
        $request = \request();
        $model_gig = parent::query()->select("bc_gigs.*");
        $model_gig->where("bc_gigs.status", "publish");
        if (!empty($location_id = $request->query('location_id'))) {
            $location = Location::where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $model_gig->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_gigs.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if(!empty($filters['cat2_id'])){
            $model_gig->where('cat2_id',$filters['cat2_id']);
        }
        if(!empty($filters['cat3_id'])){
            $model_gig->where('cat2_id',$filters['cat3_id']);
        }
        if (!empty($pri_from = $request->query('amount_from')) && !empty($pri_to = $request->query('amount_to'))) {
            $raw_sql_min_max = "( bc_gigs.basic_price >= ?)
                            AND ( bc_gigs.basic_price <= ? )";
            $model_gig->WhereRaw($raw_sql_min_max,[$pri_from,$pri_to]);
        }

        $terms = $request->query('terms');
        if($term_id = $request->query('term_id'))
        {
            $terms[] = $term_id;
        }
        if (is_array($terms) && !empty($terms)) {
            $terms = Arr::where($terms, function ($value, $key) {
                return !is_null($value);
            });
            if(!empty($terms)){
                $model_gig->join('bc_gig_term as tt', 'tt.target_id', "bc_gigs.id")->whereIn('tt.term_id', $terms);
            }
        }

        $review_scores = $request->query('review_score');
        if (is_array($review_scores) && !empty($review_scores)) {
            $where_review_score = [];
            $params = [];
            foreach ($review_scores as $number){
                $where_review_score[] = " ( bc_gigs.review_score >= ? AND bc_gigs.review_score <= ? ) ";
                $params[] = $number;
                $params[] = $number.'.9';
            }
            $sql_where_review_score = " ( " . implode("OR", $where_review_score) . " )  ";
            $model_gig->WhereRaw($sql_where_review_score,$params);
        }

        if(!empty( $service_name = $request->query("service_name") )){
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $model_gig->leftJoin('bc_gig_translations', function ($join) {
                    $join->on('bc_gigs.id', '=', 'bc_gig_translations.origin_id');
                });
                $model_gig->where('bc_gig_translations.title', 'LIKE', '%' . $service_name . '%');

            }else{
                $model_gig->where('bc_gigs.title', 'LIKE', '%' . $service_name . '%');
            }
        }
        if(!empty($lat = $request->query('map_lat')) and !empty($lgn = $request->query('map_lgn'))){
            $model_gig->orderByRaw("POW((bc_gigs.map_lng-?),2) + POW((bc_gigs.map_lat-?),2)",[$lgn,$lat]);
        }

        if(!empty( $delivery_time = $request->query("delivery_time") ) and $delivery_time != "any_time"){
            $model_gig->where('bc_gigs.basic_delivery_time', '<=', $delivery_time);
        }

        $orderby = $request->input("orderby");
        switch($orderby) {
            case"new":
                $model_gig->orderBy("id", "desc");
                break;
            case"old":
                $model_gig->orderBy("id", "asc");
                break;
            case"name_high":
                $model_gig->orderBy("title", "asc");
                break;
            case"name_low":
                $model_gig->orderBy("title", "desc");
                break;
            default:
                $model_gig->orderBy("is_featured", "desc");
                $model_gig->orderBy("id", "desc");
                break;
        }

        $model_gig->groupBy("bc_gigs.id");

        $max_guests = (int)($request->query('adults') + $request->query('children'));
        if($max_guests){
            $model_gig->where('max_guests','>=',$max_guests);
        }

        return $model_gig->with(['location','hasWishList','translations']);
    }

    public function getNumberWishlistInService($status = false)
    {
        return $this->hasOne($this->userWishListClass, 'object_id','id')->where('object_model' , $this->type)->count();
    }

    static public function getFiltersSearch()
    {
        $min_max_price = self::getMinMaxPrice();
        return [
            [
                "title"    => __("Filter Price"),
                "field"    => "price_range",
                "position" => "1",
                "min_price" => floor ( Currency::convertPrice($min_max_price[0]) ),
                "max_price" => ceil (Currency::convertPrice($min_max_price[1]) ),
            ],
            [
                "title"    => __("Review Score"),
                "field"    => "review_score",
                "position" => "2",
                "min" => "1",
                "max" => "5",
            ],
            [
                "title"    => __("Attributes"),
                "field"    => "terms",
                "position" => "3",
                "data" => Attributes::getAllAttributesForApi("event")
            ]
        ];
    }


    public function saveTag($tags_name, $tag_ids)
    {

        if (empty($tag_ids))
            $tag_ids = [];
        $tag_ids = array_merge(Tag::saveTagByName($tags_name), $tag_ids);
        $tag_ids = array_filter(array_unique($tag_ids));
        // Delete unused
        GigTag::query()->whereNotIn('tag_id', $tag_ids)->where('target_id', $this->id)->delete();
        //Add
        GigTag::addTag($tag_ids, $this->id);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'author_id');
    }

    public function cat(){
        return $this->belongsTo(GigCategory::class,'cat_id');
    }
    public function cat2(){
        return $this->belongsTo(GigCategory::class,'cat2_id');
    }
    public function cat3(){
        return $this->belongsTo(GigCategory::class,'cat3_id');
    }

    public function orderEmailToCustomer(Order $order,OrderItem $orderItem){
        Mail::to($order->customer)->queue(new GigOrderEmail($order,$orderItem,$this,'customer'));
    }

    public function orderEmailToAuthor(GigOrder $gig_order){
        Mail::to($this->author)->queue(new GigOrderEmail($gig_order,$this,'author'));
    }

    public function orderEmailToAdmin(Order $order,OrderItem $orderItem){

        if(!setting_item('admin_email')) return;

        Mail::to(setting_item('admin_email'))->queue(new GigOrderEmail($order,$orderItem,$this,'admin'));
    }

    public function initOrder(Order $order,OrderItem $orderItem){

        $gig_order = GigOrder::firstOrNew([
            'gig_id'=>$this->id,
            'order_item_id'=>$orderItem->id
        ]);
        if($gig_order->id){
            return $gig_order;
        }
        $packages = collect($this->packages);
        $package = $packages->where('key',$orderItem->meta['package'] ?? '')->first();
        $data = [
            'order_id'=>$order->id,
            'author_id'=>$this->author_id,
            'customer_id'=>$order->customer_id,
            'revision'=>$package['revision'] ?? 1,
            'delivery_time'=>$package['delivery_time'] ?? 1,
            'package'=>$orderItem->meta['package'] ?? '',
            'extra_prices'=>$orderItem->meta['extra_prices'] ?? [],
            'requirements'=>$this->requirements,
            'status'=>GigOrder::INCOMPLETE,
            'price'=>$orderItem->price,
            'total'=>$orderItem->subtotal
        ];
        if(empty($this->requirements)){
            $data['status'] = GigOrder::IN_PROGRESS;
            $data['start_date'] = date('Y-m-d H:i:s');
            $delivery_date = date('Y-m-d H:i:s', strtotime('+'.($package['delivery_time'] ?? 1).' days'));
            $data['delivery_date'] = $delivery_date;
        }
        $gig_order->fillByAttr(array_keys($data),$data);

        $is_new = $gig_order->id;

        $gig_order->save();

        if($gig_order->status == GigOrder::IN_PROGRESS){
            $gig_order->addActivity(GigOrderActivity::TYPE_ORDER_STARTED);
            $gig_order->addActivity(GigOrderActivity::TYPE_DELIVERY_DATE);
        }

        if($is_new){
            $gig_order->addActivity('init',[],$order->customer_id);
        }

        $gig_order->is_new = 1;

        return $gig_order;
    }

    public function addToCart($param){
        $extra_prices = [];
        $base_price = 0;
        switch ($param['package']){
            case"basic":
                $base_price = $this->basic_price;
                break;
            case"standard":
                $base_price = $this->standard_price;
                break;
            case"premium":
                $base_price = $this->premium_price;
                break;
        }
        if(empty($base_price)){
            return [
                'status'=>0,
                'message'=> __("Please select another package")
            ];
        }
        $tmp_extra_price = [];
        if (!empty($this->extra_price) and !empty($param['extra_services'])) {
            $extra_price_input = $param['extra_services'];
            $extra_prices = $this->extra_price;
            foreach ( $extra_prices as $k => $type) {
                if (isset($extra_price_input[$k]) and !empty($extra_price_input[$k]['enable'])) {
                    $tmp_extra_price[] = $type;
                }
            }
        }
        CartManager::clear();
        CartManager::add($this,$this->title,1,$base_price,['package'=>$param['package'],'extra_prices'=>$tmp_extra_price]);
        return [
            'status'=>1,
            'message'=> __("Add to cart success!")
        ];
    }



    public function count_remain_review()
    {
        $number_review = Review::countReviewByServiceID($this->id, Auth::id(), false, $this->type) ?? 0;
        $number_booking = OrderItem::where("bc_order_items.object_id", $this->id)
            ->rightJoin('bc_orders', function ($join) {
                $join->on('bc_orders.id', '=', 'bc_order_items.order_id')
                    ->where('bc_orders.customer_id', Auth::id())
                    ->where('bc_orders.status',"completed");
            })
            ->count("bc_order_items.id");

        $number = $number_booking - $number_review;
        if($number < 0) $number = 0;
        return $number;
    }

    public function getTags()
    {
        $tags = GigTag::where('target_id', $this->id)->get();
        $tag_ids = [];
        if (!empty($tags)) {
            foreach ($tags as $key => $value) {
                $tag_ids[] = $value->tag_id;
            }
        }
        return Tag::whereIn('id', $tag_ids)->with('translations')->get();
    }
}
