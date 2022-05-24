<?php
namespace Modules\Candidate\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Job\Models\Job;

class CandidateContact extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_candidate_contact';
    protected $fillable = [
        'origin_id',
        'name',
        'email',
        'message',
        'status',
        'contact_to',
        'object_id',
        'object_model'
    ];

    public function job(){
        return $this->belongsTo(Job::class, 'object_id', 'id');
    }
}
