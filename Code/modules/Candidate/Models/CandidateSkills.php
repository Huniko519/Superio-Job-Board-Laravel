<?php
namespace Modules\Candidate\Models;

use App\BaseModel;

class CandidateSkills extends BaseModel
{
    protected $table = 'bc_candidate_skills';
    protected $fillable = [
        'origin_id',
        'skill_id'
    ];
}
