<?php


namespace Modules\Order\Listeners;


use Illuminate\Support\Facades\Mail;
use Modules\Order\Emails\OrderEmail;
use Modules\Order\Events\OrderUpdated;

class OrderUpdatedNotification
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $order = $event->_order;
        switch ($order->status) {
            case "completed":
                // Send Email
                Mail::to($order->customer)->queue(new OrderEmail($order));

                if(setting_item('admin_email')) {
                    Mail::to(setting_item('admin_email'))->queue(new OrderEmail($order, 'admin'));
                }

            break;
        }
    }
}
