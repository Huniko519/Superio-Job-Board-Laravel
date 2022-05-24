<?php
namespace Modules\Job\Exports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Job\Models\JobCandidate;
use Modules\User\Models\Subscriber;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApplicantsExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        $candidate_id = request()->query('candidate_id');
        $rows = JobCandidate::with(['jobInfo', 'candidateInfo', 'cvInfo', 'company', 'company.getAuthor'])
            ->whereHas('jobInfo', function ($q){
                $job_id = request()->query('job_id');
                $company_id = request()->query('company_id');
                if (!Auth::user()->hasPermission('job_manage_others')) {
                    $company_id = Auth::user()->company->id ?? '';
                    $q->where('company_id', $company_id);
                }
                if( $company_id && Auth::user()->hasPermission('job_manage_others')){
                    $q->where('company_id', $company_id);
                }
                if($job_id){
                    $q->where("id", $job_id);
                }
            });

        if( $candidate_id && Auth::user()->hasPermission('job_manage_others')){
            $rows->where('candidate_id', $candidate_id);
        }
        $rows = $rows->orderBy('id', 'desc')->get();
        return $rows;
    }

    /**
     * @var Subscriber $jobCandidate
     * @return array
     */
    public function map($jobCandidate): array
    {
        return [
            ltrim($jobCandidate->candidateInfo->getAuthor->getDisplayName() ?? '',"=-"),
            ltrim($jobCandidate->jobInfo->title,"=-"),
            ltrim($jobCandidate->message,"=-"),
            ltrim(display_date($jobCandidate->created_date),"=-"),
            ltrim($jobCandidate->status,"=-")
        ];
    }

    public function headings(): array
    {
        return [
            'Candidate',
            'Job Title',
            'Message',
            'Date Applied',
            'Status'
        ];
    }
}
