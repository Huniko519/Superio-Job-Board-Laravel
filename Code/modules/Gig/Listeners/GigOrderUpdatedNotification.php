<?php


namespace Modules\Gig\Listeners;


use Modules\Gig\Models\Gig;
use Modules\Order\Events\OrderUpdated;

class GigOrderUpdatedNotification
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $order = $event->_order;
        switch ($order->status){
            case "completed":
                foreach ($order->items as $orderItem){
                    switch ($orderItem->object_model){
                        case "gig":
                            $gig = Gig::find($orderItem->object_id);
                            if($gig){
                                // Create Gig Order
                                $gig_order = $gig->initOrder($order,$orderItem);

                                if($gig_order->is_new) {
                                    // Notification
                                    $gig->orderEmailToAuthor($gig_order);
                                }
                            }
                            break;
                    }
                }
                break;
        }
    }

}
