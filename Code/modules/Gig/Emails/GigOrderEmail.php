<?php


namespace Modules\Gig\Emails;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Gig\Models\Gig;
use Modules\Gig\Models\GigOrder;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;

class GigOrderEmail extends \Illuminate\Mail\Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $_gig_order;
    protected $_gig;
    protected $email_to;

    public function __construct(GigOrder $gig_order,Gig $gig, $to = 'customer')
    {
        $this->_gig_order = $gig_order;
        $this->_gig = $gig;
        $this->email_to = $to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->_gig_order->order;
        $data = [
            'email_to'=>$this->email_to,
            'gig_order'=>$this->_gig_order,
            'author'=>$this->_gig->author,
            'gig'=>$this->_gig,
            'order'=>$order
        ];

        switch ($this->email_to){
            case "author":
                $subject = __("New order: ").'#'.$order->id;
                break;
            default:
                $subject = __("Thank you for your order: ").'#'.$order->id;
                break;
        }
        return $this->subject($subject)->view('Gig::emails.order_author',$data);
    }
}
