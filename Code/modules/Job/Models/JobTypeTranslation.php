<?php
namespace Modules\Job\Models;

use App\BaseModel;

class JobTypeTranslation extends BaseModel
{
    protected $table = 'bc_job_type_translations';
    protected $fillable = [
        'name',
    ];
}
