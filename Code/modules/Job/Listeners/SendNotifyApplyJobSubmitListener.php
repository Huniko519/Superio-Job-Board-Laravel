<?php

    namespace Modules\Job\Listeners;

    use App\Notifications\PrivateChannelServices;
    use Modules\Job\Events\CandidateApplyJobSubmit;

    class SendNotifyApplyJobSubmitListener
    {

        public function handle(CandidateApplyJobSubmit $event)
        {
            $row = $event->row;
            $user = $row->company->getAuthor ?? $row->jobInfo->user;
            $data = [
                'id' => $row->id,
                'event'   => 'CandidateApplyJobSubmit',
                'to'      => 'employer',
                'name' => $user->display_name ?? '',
                'avatar' => $row->candidateInfo->getAuthor->avatar_url ?? '',
                'link' => route("job.admin.allApplicants"),
                'type' => 'apply_job',
                'message' => __(':name have applied to the job :job', ['name' => $row->candidateInfo->getAuthor->getDisplayName() ?? '', 'job' => $row->jobInfo->title ?? ''])
            ];

            $user->notify(new PrivateChannelServices($data));
        }
    }
