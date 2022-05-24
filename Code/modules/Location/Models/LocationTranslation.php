<?php
namespace Modules\Location\Models;

use App\BaseModel;

class LocationTranslation extends BaseModel
{
    protected $table = 'bc_location_translations';
    protected $fillable = ['name'];
    protected $seo_type = 'location_translation';
}
