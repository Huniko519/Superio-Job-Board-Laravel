<?php


namespace Modules\Order\Models;


use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends BaseModel
{

    use SoftDeletes;
    protected $table = 'bc_order_items';

    protected $casts = [
        'meta'=>'array'
    ];

    public function model(){
        $keys = get_bookable_services();
        if(array_key_exists($this->object_model,$keys)){
            return $keys[$this->object_model]::find($this->object_id);
        }
        return false;
    }

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }

    public function getStatusNameAttribute()
    {
        return booking_status_to_text($this->status);
    }

    public function getSubtotalAttribute(){
        return $this->price * $this->qty + $this->extra_price_total;
    }

    public function getExtraPriceTotalAttribute(){
        $t = 0;
        if(!empty($this->meta['extra_prices']))
        {
            foreach ($this->meta['extra_prices'] as $extra_price){
                $t += (float)($extra_price['price']);
            }
        }
        return $t;
    }

}
