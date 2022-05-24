<?php


namespace Modules\User\Listeners;


use Modules\Order\Events\OrderUpdated;
use Modules\User\Models\Plan;

class UpdateUserPlanListener
{
    /**
     * Handle the event.
     *
     * @param $event OrderUpdated
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $order = $event->_order;
        switch ($order->status){
            case "completed":
                foreach ($order->items as $item){
                    switch ($item->object_model){
                        case "plan":
                            $plan = Plan::find($item->object_id);
                            if($plan) {
                                $user = $order->customer;
                                $user->applyPlan($plan,$item->price,$item->meta['annual'] ?? 0);
                            }
                            break;
                    }
                }
                break;
        }

    }
}
