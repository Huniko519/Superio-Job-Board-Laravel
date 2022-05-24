<?php
namespace Modules\Gig\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class GigCategoryTypeTranslation extends BaseModel
{
    protected $table = 'bc_gig_cat_type_trans';
    protected $fillable = [
        'name',
        'content',
    ];

}
