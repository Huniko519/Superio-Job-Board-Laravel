<?php


namespace Modules\User\Models;


use App\BaseModel;

class UserViews extends BaseModel
{
    protected $table  = 'user_views';

    public function user(){
        return $this->belongsTo(User::class,'id');
    }
}
