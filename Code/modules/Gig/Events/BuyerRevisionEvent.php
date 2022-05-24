<?php
namespace Modules\Gig\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Gig\Models\GigOrderActivity;

class BuyerRevisionEvent
{
    use Dispatchable, SerializesModels;

    public $_orderActivity;

    public function __construct(GigOrderActivity $orderActivity){
        $this->_orderActivity = $orderActivity;
    }
}
