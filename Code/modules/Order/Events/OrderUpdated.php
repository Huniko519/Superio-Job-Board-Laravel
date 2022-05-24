<?php


namespace Modules\Order\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Models\Order;

class OrderUpdated
{
    use Dispatchable, SerializesModels;

    public $_order;

    public function __construct(Order $order){
        $this->_order = $order;
    }
}
