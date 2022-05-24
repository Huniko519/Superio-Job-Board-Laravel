<?php


namespace Modules\Order\Emails;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Order\Models\Order;

class OrderEmail extends \Illuminate\Mail\Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $_order;
    protected $email_to;

    public function __construct(Order $order,$to = 'customer')
    {
        $this->_order = $order;
        $this->email_to = $to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'email_to'=>$this->email_to,
            'row'=>$this->_order,
        ];
        $subject = __("Thank you for your order: :id",['id'=>'#'.$this->_order->id]);
        if($this->email_to == 'admin'){
            $subject = __("New order: :id from :name",['id'=>'#'.$this->_order->id,'name'=>$this->_order->customer->dislay_name ?? '']);
        }
        return $this->subject($subject)->view('Order::emails.order',$data);
    }

}
