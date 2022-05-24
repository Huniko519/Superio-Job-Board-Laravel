<?php


namespace Modules\Gig\Models;


use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Media\Models\MediaFile;

class GigOrderActivity extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bc_gig_order_activities';

    protected $casts = [
        'meta'=>'array'
    ];

    const TYPE_REQUIREMENTS = 'requirements';
    const TYPE_ORDER_STARTED = 'order-started';
    const TYPE_DELIVERY_DATE = 'delivery-date';
    const TYPE_DELIVERED = 'delivered';
    const TYPE_REVISION = 'revision';
    const TYPE_ORDER_COMPLETED = 'order-completed';
    const TYPE_NORMAL_MESSAGE = 'normal-message';

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function files(){
        if(!empty($this->file_ids)){
            $file_ids = explode(',', $this->file_ids);
            $files = MediaFile::query()->whereIn('id', $file_ids)->get();
        }
        return $files ?? false;
    }

    public function gigOrder(){
        return $this->belongsTo(GigOrder::class, 'gig_order_id');
    }
}
