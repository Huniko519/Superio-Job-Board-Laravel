<?php
namespace Modules\Gig\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class GigCategoryType extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_gig_cat_types';
    protected $fillable = [
        'name',
        'content',
        'slug',
        'status',
        'cat_id',
        'image_id'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    protected $attributes = [
        'status'=>'publish'
    ];

    protected $casts = [
        'cat_children'=>'array'
    ];

    public static function getModelName()
    {
        return __("Gig Category Type");
    }

    public function cat(){
        return $this->belongsTo(GigCategory::class,'cat_id');
    }


    public function children(){
        if(empty($this->cat_children) and !is_array($this->cat_children)) return [];

        return GigCategory::query()->whereIn('id',$this->cat_children)->get();
    }
}
