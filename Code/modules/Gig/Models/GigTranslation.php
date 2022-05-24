<?php

namespace Modules\Gig\Models;

use App\BaseModel;

class GigTranslation extends BaseModel
{
    protected $table = 'bc_gig_translations';

    protected $fillable = [
        'title',
        'content',
        'packages',
        'package_compare',
        'requirements',
        'faqs',
    ];

    protected $slugField     = false;
    protected $seo_type = 'gig_translation';

    protected $cleanFields = [
        'content'
    ];
    protected $casts = [
        'packages'  => 'array',
        'package_compare'  => 'array',
        'requirements'  => 'array',
        'faqs'  => 'array',
    ];

    public function getSeoType(){
        return $this->seo_type;
    }

    public static function boot() {
		parent::boot();
		static::saving(function($table)  {
			unset($table->extra_price);
			unset($table->price);
			unset($table->sale_price);
		});
	}
}
