<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/16/2019
 * Time: 2:05 PM
 */
namespace Modules\Candidate\Models;

use App\BaseModel;

class CategoryTranslation extends BaseModel
{
    protected $table = 'bc_category_translations';
    protected $fillable = ['name', 'content'];
    protected $seo_type = 'cat_translation';
    protected $cleanFields = [
        'content'
    ];
}
