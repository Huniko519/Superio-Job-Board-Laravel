<?php


namespace Modules\Order\Models;


use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Order\Events\OrderUpdated;

class Order extends BaseModel
{

    const FAILED = 'failed';
    const ON_HOLD = 'on_hold';
    const DRAFT = 'draft';
    const COMPLETED = 'completed';
    use SoftDeletes;
    protected $table = 'bc_orders';

    protected $casts = [
        'billing'=>'array'
    ];


    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function items(){
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function syncTotal(){
        $this->subtotal = $this->items->sum('subtotal');
        $this->total = $this->subtotal;
        $this->save();
    }

    public function getDetailUrl(){
        return route('order.detail',['id'=>$this->id]);
    }
    public function getGatewayObjAttribute()
    {
        return $this->gateway ? get_payment_gateway_obj($this->gateway) : false;
    }

    public function getStatusNameAttribute()
    {
        return booking_status_to_text($this->status);
    }

    public function getMeta($key, $default = '')
    {
        $val = OrderMeta::query()->where([
            'order_id' => $this->id,
            'name'       => $key
        ])->first();
        if (!empty($val)) {
            return $val->val;
        }
        return $default;
    }

    public function getJsonMeta($key, $default = [])
    {
        $meta = $this->getMeta($key, $default);
        if(empty($meta)) return false;
        return json_decode($meta, true);
    }

    public function addMeta($key, $val, $multiple = false)
    {

        if (is_object($val) or is_array($val))
            $val = json_encode($val);
        if ($multiple) {
            return OrderMeta::create([
                'name'       => $key,
                'val'        => $val,
                'order_id' => $this->id
            ]);
        } else {
            $old = OrderMeta::query()->where([
                'order_id' => $this->id,
                'name'       => $key
            ])->first();
            if ($old) {
                $old->val = $val;
                return $old->save();

            } else {
                return OrderMeta::create([
                    'name'       => $key,
                    'val'        => $val,
                    'order_id' => $this->id
                ]);
            }
        }
    }

    public function paymentUpdated(Payment $payment){
        switch ($payment->status){
            case 'completed':
                if($this->status == 'draft'){
                    $this->status = $payment->status;
                    $this->payment_id = $payment->id;
                    $this->paid = $payment->amount;
                    $this->save();

                    $this->items()->update(['status'=>$this->status]);

                    OrderUpdated::dispatch($this);
                }
                break;
        }
    }
}
