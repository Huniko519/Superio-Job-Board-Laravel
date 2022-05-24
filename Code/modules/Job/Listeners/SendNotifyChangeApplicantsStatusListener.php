<?php

    namespace Modules\Job\Listeners;

    use App\Notifications\PrivateChannelServices;
    use Modules\Job\Events\EmployerChangeApplicantsStatus;
    use Modules\User\Models\User;

    class SendNotifyChangeApplicantsStatusListener
    {

        public function handle(EmployerChangeApplicantsStatus $event)
        {
            $row = $event->row;
            $user = User::find($row->candidate_id);
            if(!empty($user)) {
                $data = [
                    'id' => $row->id,
                    'event' => 'EmployerChangeApplicantsStatus',
                    'to' => 'employer',
                    'name' => $user->display_name ?? '',
                    'avatar' => $row->company->getAuthor->avatar_url ?? ($row->jobInfo->user->avatar_url ?? ''),
                    'link' => route("candidate.admin.myApplied"),
                    'type' => 'apply_job',
                    'message' => __('Employer :status you from job :job', ['status' => $row->status ?? '', 'job' => $row->jobInfo->title ?? ''])
                ];

                $user->notify(new PrivateChannelServices($data));
            }
        }
    }
