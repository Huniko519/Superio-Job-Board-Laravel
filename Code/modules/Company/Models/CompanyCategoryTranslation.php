<?php
namespace Modules\Company\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyCategoryTranslation extends BaseModel
{

    protected $table = 'bc_company_category_translations';
    protected $fillable = ['name', 'content'];
    protected $seo_type = 'company_cat_translation';
    protected $cleanFields = [
        'content'
    ];
}
