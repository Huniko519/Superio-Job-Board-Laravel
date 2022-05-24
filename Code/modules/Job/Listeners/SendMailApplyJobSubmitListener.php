<?php

    namespace Modules\Job\Listeners;

    use Illuminate\Support\Facades\Mail;
    use Modules\Job\Emails\ApplyJobSubmitEmail;
    use Modules\Job\Emails\ChangeApplicantsStatusEmail;
    use Modules\Job\Events\CandidateApplyJobSubmit;
    use Modules\Job\Events\EmployerChangeApplicantsStatus;
    use Modules\User\Models\User;

    class SendMailApplyJobSubmitListener
    {
        /**
         * Create the event listener.
         *
         * @return void
         */
        const CODE = [
            'job_title'    => '[job_title]',
            'job_url'    => '[job_url]',
            'candidate_name'     => '[candidate_name]',
            'candidate_url'     => '[candidate_url]',
            'employer_name'     => '[employer_name]',
            'message'     => '[message]',
            'all_applicants_url' => '[all_applicants_url]'
        ];
        public $row;

        public function handle(CandidateApplyJobSubmit $event)
        {
            $row = $event->row;
            $user = $row->company->getAuthor ?? $row->jobInfo->user;
            if(!empty($user) && !empty($user->email)) {
                $data = [
                    'job_title' => $row->jobInfo->title ?? '',
                    'job_url' => $row->jobInfo->getDetailUrl() ?? '',
                    'candidate_name' => $row->candidateInfo->getAuthor->getDisplayName() ?? '',
                    'candidate_url' => $row->candidateInfo->getDetailUrl() ?? '',
                    'employer_name' => $user->display_name ?? '',
                    'message' => $row->message ?? '',
                    'all_applicants_url' => route("job.admin.allApplicants")
                ];
                if($user->locale){
                    $old = app()->getLocale();
                    app()->setLocale($user->locale);
                }

                $body = $this->replaceContentEmail($data, setting_item_with_lang('content_email_apply_job_submit',app()->getLocale()));
                Mail::to($user->email)->send(new ApplyJobSubmitEmail($body));

                if(!empty($old)){
                    app()->setLocale($old);
                }
            }
        }

        public function replaceContentEmail($data, $content)
        {
            if (!empty($content)) {
                foreach (self::CODE as $item => $value) {
                    $content = str_replace($value, @$data[$item], $content);
                }
            }
            return $content;
        }

    }
