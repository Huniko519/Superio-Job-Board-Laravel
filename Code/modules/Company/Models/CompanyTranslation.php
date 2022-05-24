<?php
namespace Modules\Company\Models;

use App\BaseModel;

class CompanyTranslation extends BaseModel
{
    protected $table = 'bc_company_translations';
    protected $fillable = ['name', 'about'];
    protected $seo_type = 'company_translation';
    protected $cleanFields = [
        'about'
    ];
}
