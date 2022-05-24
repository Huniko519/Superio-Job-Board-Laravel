<?php
namespace Modules\Job\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategoryTranslation extends BaseModel
{
    protected $table = 'bc_job_category_translations';
    protected $fillable = ['name', 'content'];
    protected $seo_type = 'job_cat_translation';
    protected $cleanFields = [
        'content'
    ];
}
