<?php


namespace Modules\Order\Models;


use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    CONST ON_HOLD = 'on_hold';
    CONST COMPLETED = 'completed';

    use SoftDeletes;
    protected $table = 'bc_payments';

    protected $attributes = [
        'status'=>'draft'
    ];


    public function getMeta($key, $default = '')
    {
        $val = PaymentMeta::query()->where([
            'payment_id' => $this->id,
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
            return PaymentMeta::create([
                'name'       => $key,
                'val'        => $val,
                'payment_id' => $this->id
            ]);
        } else {
            $old = PaymentMeta::query()->where([
                'payment_id' => $this->id,
                'name'       => $key
            ])->first();
            if ($old) {
                $old->val = $val;
                return $old->save();

            } else {
                return PaymentMeta::create([
                    'name'       => $key,
                    'val'        => $val,
                    'payment_id' => $this->id
                ]);
            }
        }
    }

    public function getDetailUrl(){
        switch ($this->object_model){
            case "order":
                $order = Order::find($this->object_id);
                $url = $order->getDetailUrl();
                break;
        }
        return $url;
    }
    public function order(){
        switch ($this->object_model){
            default:
                return $this->belongsTo(Order::class,'object_id')->withDefault();
        }
    }
}
