<?php
namespace Modules\Job;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Job\Events\CandidateApplyJobSubmit;
use Modules\Job\Events\CandidateDeleteApplied;
use Modules\Job\Events\EmployerChangeApplicantsStatus;
use Modules\Job\Listeners\SendMailApplyJobSubmitListener;
use Modules\Job\Listeners\SendMailChangeApplicantsStatusListen;
use Modules\Job\Listeners\SendNotifyApplyJobSubmitListener;
use Modules\Job\Listeners\SendNotifyChangeApplicantsStatusListener;
use Modules\Job\Listeners\SendNotifyDeleteAppliedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CandidateApplyJobSubmit::class => [
            SendNotifyApplyJobSubmitListener::class,
            SendMailApplyJobSubmitListener::class
        ],
        CandidateDeleteApplied::class => [
            SendNotifyDeleteAppliedListener::class
        ],
        EmployerChangeApplicantsStatus::class => [
            SendNotifyChangeApplicantsStatusListener::class,
            SendMailChangeApplicantsStatusListen::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
