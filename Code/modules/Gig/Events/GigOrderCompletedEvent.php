<?php


namespace Modules\Gig\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Gig\Models\GigOrder;

class GigOrderCompletedEvent
{
    use Dispatchable, SerializesModels;

    public $_order;

    public function __construct(GigOrder $order){
        $this->_order = $order;
    }
}
