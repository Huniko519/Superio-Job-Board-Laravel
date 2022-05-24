<?php


namespace Modules\Gig\Models;


use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Order\Models\Order;

class GigOrder extends BaseModel
{

    const INCOMPLETE = 'incomplete';
    const IN_PROGRESS = 'in-progress';
    const DELIVERED = 'delivered';
    const IN_REVISION = 'in-revision';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

    use SoftDeletes;

    protected $table = 'bc_gig_orders';

    protected $casts = [
        'extra_prices'=>'array',
        'requirements'=>'array'
    ];

    protected $appends = [
        'status_text'
    ];

    protected $fillable = [
        'gig_id',
        'order_item_id'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
    public function author(){
        return $this->belongsTo(User::class,'author_id');
    }
    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
    public function gig(){
        return $this->belongsTo(Gig::class,'gig_id');
    }

    public function activities(){
        return $this->hasMany(GigOrderActivity::class, 'gig_order_id', 'id');
    }

    public function delivery(){
        return $this->hasMany(GigOrderActivity::class, 'gig_order_id', 'id')->where('bc_gig_order_activities.type', GigOrderActivity::TYPE_DELIVERED);
    }

    public function revisions(){
        return $this->hasMany(GigOrderActivity::class, 'gig_order_id', 'id')->where('bc_gig_order_activities.type', GigOrderActivity::TYPE_REVISION);
    }

    public function addActivity($type,$data = [],$user_id = false){
        if(!$user_id){
            $user_id = auth()->id();
        }

        $a = new GigOrderActivity();
        $a->gig_order_id = $this->id;
        $a->user_id = $user_id;
        $a->setAttribute('type', $type);
        foreach ($data as $k=>$v){
            $a->setAttribute($k,$v);
        }
        $a->save();
        return $a;
    }

    public function getBuyerNextStatuesAttribute(){
        switch ($this->status){
            case self::DELIVERED:
                return [
                    self::IN_REVISION,
                    self::COMPLETED
                ];
                break;
            case self::IN_REVISION:
                return [
                    self::COMPLETED
                ];
                break;

        }
    }
    public function getSellerNextStatuesAttribute(){
        switch ($this->status){
            case self::INCOMPLETE:
                return [
                    self::IN_PROGRESS,
                    self::CANCELLED
                ];
                break;
            case self::IN_PROGRESS:
            case self::IN_REVISION:
                return [
                    self::DELIVERED
                ];
                break;
        }
    }

    public function getStatusTextAttribute(){
        switch ($this->status){
            case self::IN_PROGRESS:
                return __("In Progress");
                break;
            case self::IN_REVISION:
                return __("In Revision");
                break;
            case self::DELIVERED:
                return __("Delivered");
                break;
            case self::INCOMPLETE:
                return __("Incomplete");
                break;
            case self::COMPLETED:
                return __("Completed");
                break;
            case self::CANCELLED:
                return __("Cancelled");
                break;
            default:
                return ucfirst($this->status ?? '');
                break;
        }
    }

    public function orderExpired(){
        if(strtotime('now') > strtotime($this->delivery_date)){
            return true;
        }
        return false;
    }
}
