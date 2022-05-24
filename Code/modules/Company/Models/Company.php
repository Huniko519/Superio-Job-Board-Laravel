<?php
namespace Modules\Company\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\SEO;
use Modules\Company\Models\CompanyCategory as Category;
use Modules\Core\Models\Terms;
use Modules\Job\Models\Job;
use Modules\Job\Models\JobCandidate;
use Modules\Location\Models\Location;
use Modules\Core\Models\Attributes;
use Modules\Company\Models\CompanyTerm;

class Company extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_companies';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'avatar_id',
        'cover_id',
        'founded_in',
        'allow_search',
        'owner_id',
        'category_id',
        'team_size',
        'about',
        'social_media',
        'city',
        'state',
        'country',
        'zip_code',
        'address',
        'slug',
        'status',
        'location_id',
        'map_lat',
        'map_lng',
        'is_featured'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'companies';
    public $type = 'company';
    protected $casts = [
        'social_media' => 'array'
    ];

    public function getDetailUrlAttribute()
    {
        return url('companies-' . $this->slug);
    }
    public function getDetailUrl($locale = false)
    {
        return url(app_get_locale(false,false,'/'). config('companies.companies_route_prefix')."/".$this->slug);
    }
    public function companyTerm()
    {
        return $this->hasMany(CompanyTerm::class, "company_id");
    }
    public function category()
    {
        $catename = $this->hasOne(CompanyCategory::class, "id", "category_id");
        return $catename;
    }
    public function teamSize()
    {
        return $this->hasOne(Terms::class, 'id', 'team_size')->with(['translations']);
    }
    public function job()
    {
        return $this->hasMany(Job::class,'company_id','id');
    }
    public function jobs()
    {
        return $this->hasMany(Job::class,'company_id','id');
    }
    public function getAuthor()
    {
        return $this->belongsTo("App\User", "owner_id", "id")->withDefault();
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id','id');
    }

    public static function search(Request $request)
    {
        $model_companies = parent::query()->select("bc_companies.*")
            ->where("bc_companies.status", "publish")
            ->where('allow_search',1);
        if (!empty($search = $request->query("s"))) {
            $model_companies->where(function($query) use ($search) {
                $query->where('bc_companies.name', 'LIKE', '%' . $search . '%');
                $query->orWhere('bc_companies.about', 'LIKE', '%' . $search . '%');
            });

            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app_get_locale() ){
                $model_companies->leftJoin('bc_company_translations', function ($join) use ($search) {
                    $join->on('bc_companies.id', '=', 'bc_company_translations.origin_id');
                });
                $model_companies->orWhere(function($query) use ($search) {
                    $query->where('bc_company_translations.name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('bc_company_translations.about', 'LIKE', '%' . $search . '%');
                });
            }

            $title_page = __('Search results : ":s"', ["s" => $search]);
        }
        if(!empty($category_id = $request->query("category")))
        {
            $category = Category::query()->where('id', $category_id)->where("status","publish")->first();
            if(!empty($category)){
                $model_companies->join('bc_company_categories', function ($join) use ($category) {
                    $join->on('bc_company_categories.id', '=', 'bc_companies.category_id')
                        ->where('bc_company_categories._lft', '>=', $category->_lft)
                        ->where('bc_company_categories._rgt', '<=', $category->_rgt);
                });
            }
        }
        if(!empty($location_id = $request->query("location")))
        {
            $location = Location::query()->where('id', $location_id)->where("status","publish")->first();
            if(!empty($location)){
                $model_companies->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_companies.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        if(!empty($from_date = $request->query("from_date")) && !empty($to_date = $request->query("to_date")))
        {
            $day_last_month = date("t", strtotime($to_date . "-12-01"));

            $model_companies->whereBetween('founded_in',[$from_date.'-01-01',$to_date.'-12-'.$day_last_month]);
        }
        if(!empty($size = $request->query("team_size")))
        {
            $model_companies->where('team_size',$size);
        }
        $terms = $request->query('terms');
        if(is_array($terms))
        {
            $terms = array_filter($terms);
        }
        if (is_array($terms) && !empty($terms)) {
            $model_companies->join('bc_company_term as ct', 'ct.company_id', "bc_companies.id")->whereIn('ct.term_id', $terms);
        }
        $orderby = $request->query("orderby",'newest');
        switch ($orderby) {
            case "random":
                $model_companies->inRandomOrder();
                break;
            case "oldest":
                $model_companies->orderBy('bc_companies.id','ASC');
                break;
            case "newest":
                $model_companies->orderBy('bc_companies.id','DESC');
                break;
        }
        $model_companies->withCount(['job' => function (Builder $query) {
            $query->where('status', 'publish');
        }]);
        $limit = $request->query("limit",10);
        return $model_companies->with(["category","location",'wishlist'])->groupBy("bc_companies.id")->paginate($limit);
    }

    public function getEditUrl()
    {
        $lang = $this->lang ?? setting_item("site_locale");
        return route('company.admin.edit',['id'=>$this->id , "lang"=> $lang]);
    }

    static public function getSeoMetaForPageList()
    {
        $meta['seo_title'] = setting_item_with_lang("company_page_list_seo_title", false, setting_item_with_lang("company_page_search_title", false, __("Companies")));
        $meta['seo_desc'] = setting_item_with_lang("company_page_list_seo_desc");
        $meta['seo_image'] = setting_item("company_page_list_seo_image", false);
        $meta['seo_share'] = setting_item_with_lang("company_page_list_seo_share");
        $meta['full_url'] = url(config('companies.companies_route_prefix'));
        return $meta;
    }

}
