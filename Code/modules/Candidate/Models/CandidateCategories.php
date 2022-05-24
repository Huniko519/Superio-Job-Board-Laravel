<?php
namespace Modules\Candidate\Models;

use App\BaseModel;

class CandidateCategories extends BaseModel
{
    protected $table = 'bc_candidate_categories';
    protected $fillable = [
        'origin_id',
        'cat_id'
    ];
}
