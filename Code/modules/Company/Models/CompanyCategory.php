<?php
namespace Modules\Company\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyCategory extends BaseModel
{
    use SoftDeletes;
    use NodeTrait;
    protected $table = 'bc_company_categories';
    protected $fillable = [
        'name',
        'content',
        'status',
        'parent_id',
        'icon'
    ];
    protected $slugField     = 'slug';
    protected $slugFromField = 'name';
    protected $seo_type = 'company_category';

    public static function getModelName()
    {
        return __("Category");
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'name');
        if (strlen($q)) {

            $query->where('title', 'name', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }
}
