<?php


namespace Modules\Order\Models;


use App\BaseModel;

class OrderMeta extends BaseModel
{
    protected $table = 'bc_order_meta';

    protected $fillable = [
        'name' ,
        'val'  ,
        'order_id',
    ];
}
