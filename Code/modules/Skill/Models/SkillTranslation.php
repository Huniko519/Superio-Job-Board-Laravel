<?php
namespace Modules\Skill\Models;

use App\BaseModel;

class SkillTranslation extends BaseModel
{
    protected $table = 'bc_skill_translations';
    protected $fillable = [
        'name'
    ];
}
