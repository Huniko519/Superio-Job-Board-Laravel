<?php


namespace Modules\Order\Listeners;


use Modules\Order\Events\PaymentUpdated;
use Modules\Order\Models\Order;

class PaymentUpdatedListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(PaymentUpdated $event)
    {
        switch ($event->_payment->object_model){
            case "order":
                $order = Order::find($event->_payment->object_id);
                if($order){
                    $order->paymentUpdated($event->_payment);
                }
                break;
        }
    }
}
