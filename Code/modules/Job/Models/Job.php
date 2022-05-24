<?php
namespace Modules\Job\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Modules\Company\Models\Company;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;
use Modules\Skill\Models\Skill;
use Modules\Job\Models\JobCategory as Category;

class Job extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_jobs';
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'thumbnail_id',
        'location_id',
        'company_id',
        'job_type_id',
        'expiration_date',
        'hours',
        'hours_type',
        'salary_min',
        'salary_max',
        'salary_type',
        'gender',
        'map_lat',
        'map_lng',
        'map_zoom',
        'experience',
        'status',
        'create_user',
        'apply_type',
        'apply_link',
        'apply_email',
        'wage_agreement',
        'gallery',
        'video'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'title';
    protected $seo_type = 'job';
    public $type = 'job';

    public static function getAll()
    {
        return self::with('cat')->get();
    }

    public function getEditUrl()
    {
        $lang = $this->lang ?? setting_item("site_locale");
        return route('job.admin.edit',['id'=>$this->id , "lang"=> $lang]);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'create_user', 'id');
    }

    public function location(){
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public function category(){
        return $this->belongsTo(JobCategory::class,'category_id','id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function getDetailUrl()
    {
        return url(app_get_locale(false, false, '/') . config('job.job_route_prefix') . "/" . $this->slug);
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

    public function isOpen(){
        if(empty($this->expiration_date)) return false;
        $estimate_time = strtotime($this->expiration_date) - strtotime('now');
        return $estimate_time >= 0;
    }

    public function jobType(){
        return $this->belongsTo(JobType::class,'job_type_id','id');
    }

    public function getSalary($show_type = true){
        $price_html = format_money($this->salary_min);
        if(!empty($this->salary_max)){
            $price_html .= ' - ' . format_money($this->salary_max);
        }
        if(!empty($this->salary_type) && $show_type){
            $price_html .= ' /'.$this->salary_type_name;
        }
        if(!empty($this->wage_agreement)){
            $price_html = __("Wage Agreement");
        }
        return $price_html;
    }

    public function getThumbnailUrl(){
        if(!empty($this->thumbnail_id)){
            return FileHelper::url($this->thumbnail_id);
        }elseif(!empty($this->company) && $this->company->avatar_id){
            return FileHelper::url($this->company->avatar_id);
        }elseif(!empty($this->user)){
            return $this->user->getAvatarUrl();
        }else{
            return false;
        }
    }

    public static function search(Request $request)
    {
        $model_job = parent::query()->select("bc_jobs.*");
        $model_job->where("bc_jobs.status", "publish");
        if(!empty($agent_id  = $request->query('agent_id'))){
            $model_job->where('create_user',$agent_id);
        }
        $location_id = $request->query('location') ?? $request->location;
        if (!empty($location_id)) {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $model_job->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_jobs.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }

        $category_id = $request->query('category') ?? $request->category;
        if (!empty($category_id)) {
            $category = Category::query()->where('id', $category_id)->where("status","publish")->first();
            if(!empty($category)){
                $model_job->join('bc_job_categories', function ($join) use ($category) {
                    $join->on('bc_job_categories.id', '=', 'bc_jobs.category_id')
                        ->where('bc_job_categories._lft', '>=', $category->_lft)
                        ->where('bc_job_categories._rgt', '<=', $category->_rgt);
                });
            }
        }
        if (!empty($job_types = $request->query('job_type'))) {
            $model_job->whereIn('job_type_id', $job_types);
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
                $model_job->where('bc_jobs.created_at', '>=', $date_p);
            }
        }

        if (!empty($experiences = $request->query('experience'))) {
            $model_job->where(function ($query) use ($experiences){
                 if (!empty($experiences) && is_array($experiences)){
                     foreach ($experiences as $key => $exp){
                         if($exp == 'fresh') {
                             $exp = 0;
                         }
                         $exp = (int)$exp;
                         if ($key == 0) {
                             $query->where([
                                 ['experience', '>=' , $exp],
                                 ['experience', '<' , $exp + 1]
                             ]);
                         } else {
                             $query->orWhere([
                                 ['experience', '>=' , $exp],
                                 ['experience', '<' , $exp + 1]
                             ]);
                         }
                     }
                 }
            });
        }

        if (!empty($pri_from = $request->query('amount_from')) && !empty($pri_to = $request->query('amount_to'))) {
            if($pri_to >= $pri_from && $pri_from > 0) {
                $raw_sql_min_max = "( (IFNULL(bc_jobs.salary_min,0) > 0 and bc_jobs.salary_min >= ? ) OR (IFNULL(bc_jobs.salary_min,0) <= 0 and bc_jobs.salary_max >= ? ) )
                                AND ( (IFNULL(bc_jobs.salary_min,0) > 0 and bc_jobs.salary_min <= ? ) OR (IFNULL(bc_jobs.salary_min,0) <= 0 and bc_jobs.salary_max <= ? ) )";
                $model_job->WhereRaw($raw_sql_min_max,[$pri_from,$pri_from,$pri_to,$pri_to]);
            }
        }

        $terms = $request->query('terms');
        if($term_id = $request->query('term_id'))
        {
            $terms[] = $term_id;
        }

        if (is_array($terms) && !empty($terms)) {
            $model_job->join('bc_property_term as tt', 'tt.target_id', "bc_properties.id")->whereIn('tt.term_id', $terms);
        }


        if(!empty( $job_name = $request->query("s") )){
            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $model_job->leftJoin('bc_job_translations', function ($join) {
                    $join->on('bc_jobs.id', '=', 'bc_job_translations.origin_id');
                });
                $model_job->where('bc_job_translations.title', 'LIKE', '%' . $job_name . '%');
            }else{
                $model_job->where('bc_jobs.title', 'LIKE', '%' . $job_name . '%');
            }
        }

        if(setting_item('job_hide_expired_jobs') == 1){
            $model_job->where('expiration_date', '>=',  date('Y-m-d H:s:i'));
        }

        if(!empty($orderby = $request->query("orderby"))) {
            switch($orderby) {
                case"new":
                    $model_job->orderBy("id", "desc");
                    break;
                case"old":
                    $model_job->orderBy("id", "asc");
                    break;
                case"name_high":
                    $model_job->orderBy("title", "asc");
                    break;
                case"name_low":
                    $model_job->orderBy("title", "desc");
                    break;
                default:
                    $model_job->orderBy("is_featured", "desc");
                    $model_job->orderBy("id", "desc");
                    break;
            }
        }else{
            $model_job->orderBy("is_featured", "desc");
            $model_job->orderBy("id", "desc");
        }

        $model_job->groupBy("bc_jobs.id");

        $limit = $request->query('limit',10);
        return $model_job->with(['location','translations', 'category', 'company', 'jobType', 'wishlist'])->paginate($limit);
    }

    public static function getMinMaxPrice()
    {
        $model = parent::selectRaw('MIN( salary_min ) AS min_price ,
                                    MAX( salary_min ) AS max_price ')->where("status", "publish")->first();
        if (empty($model->min_price) and empty($model->max_price)) {
            return [
                0,
                100
            ];
        }
        return [
            0,
            $model->max_price
        ];
    }

    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = __("Find Jobs");
        if (!empty($title = setting_item_with_lang("job_page_list_seo_title"))) {
            $meta['seo_title'] = $title;
        }else if(!empty($title = setting_item_with_lang("job_page_search_title"))) {
            $meta['seo_title'] = $title;
        }
        $meta['seo_image'] = null;
        if (!empty($title = setting_item("job_page_list_seo_image"))) {
            $meta['seo_image'] = $title;
        }
        $meta['seo_desc'] = setting_item_with_lang("job_page_list_seo_desc");
        $meta['seo_share'] = setting_item_with_lang("job_page_list_seo_share");
        $meta['full_url'] = url(config('job.job_route_prefix'));
        return $meta;
    }

    public function skills(){
        return $this->belongsToMany(Skill::class, 'bc_job_skills', 'job_id', 'skill_id');
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

    public function getSalaryTypeNameAttribute()
    {
        $salary_types = [
            'hourly' => __("hourly"),
            'daily' => __("daily"),
            'weekly' => __("weekly"),
            'monthly' => __("monthly"),
            'yearly' => __("yearly")
        ];
        return $this->salary_type ? $salary_types[$this->salary_type] : '';
    }
}
