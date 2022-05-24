<?php

    namespace Modules\Location\Models;

    use App\BaseModel;
    use Illuminate\Http\Request;
    use Kalnoy\Nestedset\NodeTrait;
    use Modules\Booking\Models\Bookable;
    use Modules\Job\Models\Job;
    use Modules\Media\Helpers\FileHelper;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Core\Models\SEO;

    class Location extends Bookable
    {
        use SoftDeletes;
        use NodeTrait;
        protected $table         = 'bc_locations';
        protected $fillable      = [
            'name',
            'sub_title',
            'image_id',
            'map_lat',
            'map_lng',
            'map_zoom',
            'status',
            'parent_id',
        ];
        protected $slugField     = 'slug';
        protected $slugFromField = 'name';
        protected $seo_type      = 'location';

        public static function getModelName()
        {
            return __("Location");
        }

        public static function searchForMenu($q = false)
        {
            $query = static::select('id', 'name');
            if (strlen($q)) {

                $query->where('name', 'like', "%" . $q . "%");
            }
            $a = $query->limit(10)->get();
            return $a;
        }

        public function getImageUrl($size = "medium")
        {
            $url = FileHelper::url($this->image_id, $size);
            return $url ? $url : '';
        }

        public function getDisplayNumberServiceInLocation($service_type)
        {
            $allServices = get_bookable_services();
            if(empty($allServices[$service_type])) return false;
            $module = new $allServices[$service_type];
            return $module->getNumberServiceInLocation($this);
        }


        public function getDetailUrl($locale = false)
        {
            return url(app_get_locale(false, false, '/') . config('location.location_route_prefix') . "/" . $this->slug);
        }

        public function getLinkForPageSearch($service_type)
        {
            $allServices = get_bookable_services();
            $module = new $allServices[$service_type];
            return $module->getLinkForPageSearch(false, ['location_id' => $this->id]);
        }


        public static function search(Request $request)
        {
            $query = parent::query()->select("bc_locations.*");
            if(!empty( $service_name = $request->query("service_name") )){
                if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                    $query->leftJoin('bc_location_translations', function ($join) {
                        $join->on('bc_locations.id', '=', 'bc_location_translations.origin_id');
                    });
                    $query->where('bc_location_translations.name', 'LIKE', '%' . $service_name . '%');

                }else{
                    $query->where('bc_locations.name', 'LIKE', '%' . $service_name . '%');
                }
            }
            $query->orderBy("id", "desc");
            $query->groupBy("bc_locations.id");
            $limit = min(20,$request->query('limit',9));
            return $query->with(['translations'])->paginate($limit);
        }

        public function dataForApi($forSingle = false){
            $translation = $this->translateOrOrigin(app()->getLocale());
            $data = [
                'id'=>$this->id,
                'title'=>$translation->name,
                'image'=>get_file_url($this->image_id),
            ];
            if($forSingle){
                $data["map_lat"] = $this->map_lat;
                $data["map_lng"] = $this->map_lng;
                $data["map_zoom"] = $this->map_zoom;
            }
            return $data;
        }

        public function getOpenJobsCount(){
            return Job::query()
                ->where('location_id', $this->id)
                ->where('expiration_date', '>=',  date('Y-m-d H:s:i'))
                ->where('status', 'publish')
                ->count();
        }

        public function openJobs(){
            return $this->hasMany(Job::class, 'location_id', 'id')
                ->where('expiration_date', '>=',  date('Y-m-d H:s:i'));
        }

    }
