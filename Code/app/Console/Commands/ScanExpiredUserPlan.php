<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\User\Models\UserPlan;
use function Clue\StreamFilter\fun;

class ScanExpiredUserPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_plan:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan all expired user plan and de activate posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UserPlan::query()->where('end_date','<=',date('Y-m-d :H:i:s'))->where('status',1)->chunkById(30,function($user_plans){
            foreach ($user_plans as $user_plan){
                $user_plan->status = 0;
                $user_plan->save();

                Log::debug("User Plan Expired for user: #".$user_plan->id);
                if(isset($user_plan->user->company)){
                    $user_plan->user->company->jobs()->update([
                        'status'=>'draft'
                    ]);
                }
            }
        });
    }
}
