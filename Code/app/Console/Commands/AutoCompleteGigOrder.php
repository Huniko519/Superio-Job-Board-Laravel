<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Gig\Events\GigOrderCompletedEvent;
use Modules\Gig\Models\GigOrder;

class AutoCompleteGigOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gig:order_complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto complete delivered order after x day';

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
        $days = (int)setting_item('gig_days_complete_order') ?? 3;
        $query = GigOrder::query()->where([
            'status'=>GigOrder::DELIVERED,
        ])->where('last_delivered','<=',date('Y-m-d H:i:s',strtotime('- '.$days.' day')));

        $query->chunkById(10,function($orders){
            foreach ($orders as $order){
                $order->status = GigOrder::COMPLETED;
                $order->meta['auto_complete'] = 1;
                $order->save();

                $order->addActivity('completed',['meta'=>['auto'=>1]]);

                Log::debug("Order auto complete: #".$order->id);

                GigOrderCompletedEvent::dispatch($order);
            }
        });
    }
}
