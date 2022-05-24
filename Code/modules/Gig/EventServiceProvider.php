<?php


namespace Modules\Gig;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Gig\Events\BuyerRevisionEvent;
use Modules\Gig\Events\SellerDeliveryEvent;
use Modules\Gig\Listeners\BuyerRevisionNotification;
use Modules\Gig\Listeners\GigOrderUpdatedNotification;
use Modules\Gig\Listeners\SellerDeliveryNotification;
use Modules\Order\Events\OrderUpdated;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        OrderUpdated::class=>[
            GigOrderUpdatedNotification::class,
        ],
        SellerDeliveryEvent::class => [
            SellerDeliveryNotification::class
        ],
        BuyerRevisionEvent::class => [
            BuyerRevisionNotification::class
        ]
    ];
}
