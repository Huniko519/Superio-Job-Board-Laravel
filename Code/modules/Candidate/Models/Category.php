<?php
namespace Modules\Candidate\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\SEO;
use Modules\Job\Models\Job;

class Category extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;
    protected $table = 'bc_categories';
    protected $fillable = [
        'name',
        'content',
        'status',
        'parent_id',
        'icon'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'candidates_category';

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

    public function getDetailUrl($locale = false)
    {
        return route('job.category.index',['slug'=>$this->slug]);
    }

    public function dataForApi(){
        $translation = $this->translateOrOrigin(app()->getLocale());
        return [
            'name'=>$translation->name,
            'id'=>$this->id,
            'url'=>$this->getDetailUrl()
        ];
    }

    public function getOpenJobsCount(){
        return Job::query()
            ->where('category_id', $this->id)
            ->where('expiration_date', '>=',  date('Y-m-d H:s:i'))
            ->where('status', 'publish')
            ->count();
    }

}
