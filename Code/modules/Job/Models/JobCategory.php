<?php
namespace Modules\Job\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;
    protected $table = 'bc_job_categories';
    protected $fillable = [
        'name',
        'content',
        'status',
        'parent_id',
        'icon'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'job_category';

    public static function getModelName()
    {
        return __("Category");
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if (strlen($q)) {

            $query->where('title', 'name', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public function getOpenJobsCount(){
        return Job::query()
            ->where('category_id', $this->id)
            ->where('expiration_date', '>=',  date('Y-m-d H:s:i'))
            ->where('status', 'publish')
            ->count();
    }

    public function openJobs(){
        return $this->hasMany(Job::class, 'category_id', 'id')
            ->where('expiration_date', '>=',  date('Y-m-d H:s:i'));
    }
}
