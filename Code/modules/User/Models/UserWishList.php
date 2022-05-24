<?php
namespace Modules\User\Models;
use App\BaseModel;
use Modules\Candidate\Models\Candidate;
use Modules\Company\Models\Company;
use Modules\Job\Models\Job;

class UserWishList extends BaseModel
{
    protected $table = 'user_wishlist';
    protected $fillable = [
        'object_id',
        'object_model',
        'user_id'
    ];

    public function service()
    {
        $allServices = [
            'candidate'=>Candidate::class,
            'company'=>Company::class,
            'job'=>Job::class,
        ];
        $module = $allServices[$this->object_model];
        return $this->hasOne($module, "id", 'object_id')->where("deleted_at",null);
    }
}
