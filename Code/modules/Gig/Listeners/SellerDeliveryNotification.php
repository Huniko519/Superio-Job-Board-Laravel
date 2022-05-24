<?php
namespace Modules\Gig\Listeners;

use App\Notifications\PrivateChannelServices;
use Modules\Gig\Events\SellerDeliveryEvent;

class SellerDeliveryNotification
{
    public function handle(SellerDeliveryEvent $event)
    {
        $orderActivity = $event->_orderActivity;

        $user = !empty($orderActivity->gigOrder->customer) ? $orderActivity->gigOrder->customer : false;
        if(!empty($user)){
            $data = [
                'id' => $orderActivity->gigOrder->id,
                'event'   => 'SellerDeliveryEvent',
                'to'      => 'buyer',
                'name' => $user->display_name ?? '',
                'avatar' => $orderActivity->gigOrder->author->avatar_url ?? '',
                'link' => route("buyer.order", ['id' => $orderActivity->gigOrder->id]).'#activity-'.$orderActivity->id,
                'type' => 'delivery',
                'message' => __(':seller have delivered to order #:order_id', ['seller' => $orderActivity->gigOrder->author->getDisplayName() ?? '', 'order_id' => $orderActivity->gigOrder->id ])
            ];
            $user->notify(new PrivateChannelServices($data));
        }

    }

}
