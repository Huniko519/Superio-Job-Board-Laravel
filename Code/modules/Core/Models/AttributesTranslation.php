<?php
namespace Modules\Core\Models;

use App\BaseModel;

class AttributesTranslation extends BaseModel
{
    protected $table = 'bc_attrs_translations';
    protected $fillable = [
        'name',
    ];
}