<?php
namespace Modules\Gig\Listeners;

use App\Notifications\PrivateChannelServices;
use Modules\Gig\Events\BuyerRevisionEvent;
use Modules\Gig\Events\SellerDeliveryEvent;

class BuyerRevisionNotification
{
    public function handle(BuyerRevisionEvent $event)
    {
        $orderActivity = $event->_orderActivity;

        $user = !empty($orderActivity->gigOrder->author) ? $orderActivity->gigOrder->author : false;
        if(!empty($user)){
            $data = [
                'id' => $orderActivity->gigOrder->id,
                'event'   => 'BuyerRevisionEvent',
                'to'      => 'seller',
                'name' => $user->display_name ?? '',
                'avatar' => $orderActivity->gigOrder->customer->avatar_url ?? '',
                'link' => route("seller.order", ['id' => $orderActivity->gigOrder->id]).'#activity-'.$orderActivity->id,
                'type' => 'revision',
                'message' => __(':buyer have revision to order #:order_id', ['buyer' => $orderActivity->gigOrder->customer->getDisplayName() ?? '', 'order_id' => $orderActivity->gigOrder->id ])
            ];
            $user->notify(new PrivateChannelServices($data));
        }

    }

}
