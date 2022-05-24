<?php
namespace Modules\Contact\Models;

use App;
use App\BaseModel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bc_contact';
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status'
    ];
}
