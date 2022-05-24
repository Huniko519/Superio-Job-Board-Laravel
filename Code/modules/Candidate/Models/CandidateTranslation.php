<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/16/2019
 * Time: 2:05 PM
 */
namespace Modules\Candidate\Models;

use App\BaseModel;

class CandidateTranslation extends BaseModel
{
    protected $table = 'bc_candidate_translation';
    protected $fillable = ['title', 'content'];
    protected $seo_type = 'candidate_translation';
    protected $cleanFields = [
        'content'
    ];
}
