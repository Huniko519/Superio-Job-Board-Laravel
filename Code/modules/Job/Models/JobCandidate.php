<?php
namespace Modules\Job\Models;

use App\BaseModel;
use Modules\Candidate\Models\Candidate;
use Modules\Candidate\Models\CandidateCvs;
use Modules\Company\Models\Company;

class JobCandidate extends BaseModel
{
    protected $table = 'bc_job_candidates';
    protected $fillable = [
        'job_id',
        'candidate_id',
        'company_id',
        'cv_id',
        'message'
    ];

    public function jobInfo()
    {
        return $this->hasOne(Job::class, "id", 'job_id');
    }

    public function candidateInfo()
    {
        return $this->hasOne(Candidate::class, "id", 'candidate_id');
    }

    public function cvInfo()
    {
        return $this->hasOne(CandidateCvs::class, "id", 'cv_id');
    }

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }
}
