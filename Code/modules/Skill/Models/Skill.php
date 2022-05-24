<?php

namespace Modules\Skill\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends BaseModel
{
    use SoftDeletes;
    protected $table         = 'bc_skills';
    protected $fillable      = [
        'name',
        'status'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';

    public static function getModelName()
    {
        return __("Skill");
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if (strlen($q)) {

            $query->where('name', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }
}
