<?php
namespace Modules\Gig\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class GigCategory extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;
    protected $table = 'bc_gig_cat';
    protected $fillable = [
        'name',
        'content',
        'slug',
        'status',
        'parent_id',
        'news_cat_id',
        'image_id',
        'faqs',
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    protected $casts = [
        'faqs'=>'array'
    ];
    protected $attributes = [
        'status'=>'publish'
    ];

    public static function getModelName()
    {
        return __("Gig Category");
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
        return route('gig.category',['slug'=>$this->slug]);
    }

    public static function getLinkForPageSearch($locale = false, $param = [])
    {
        return route('gig.index',$param);
    }

    public function dataForApi(){
        $translation = $this->translateOrOrigin(app()->getLocale());
        return [
            'id'=>$this->id,
            'name'=>$translation->name,
            'slug'=>$this->slug,
        ];
    }

    public function types(){
        return $this->hasMany(GigCategoryType::class,'cat_id');
    }

}
