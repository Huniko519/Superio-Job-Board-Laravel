<?php


namespace Modules\Order\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Models\Payment;

class PaymentUpdated
{
    use Dispatchable, SerializesModels;

    public $_payment;

    public function __construct(Payment $payment){
        $this->_payment = $payment;
    }
}
