<?php
namespace Modules\Gig\Models;

use App\BaseModel;

class GigTerm extends BaseModel
{
    protected $table = 'bc_gig_term';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}
