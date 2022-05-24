<?php
namespace Modules\Job\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobType extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_job_types';
    protected $fillable = [
        'name',
        'slug',
        'status',
        'parent_id'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    public static function getModelName()
    {
        return __("Job Types");
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
    public function getDetailUrl(){
        return url(app_get_locale(false, false, '/') . config('job.job_route_prefix').'/job-type/'.$this->slug);
    }

    public function dataForApi(){
        $translation = $this->translateOrOrigin(app()->getLocale());
        return [
            'id'=>$this->id,
            'name'=>$translation->name,
            'slug'=>$this->slug,
        ];
    }
}
