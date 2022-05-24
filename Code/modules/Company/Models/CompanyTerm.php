<?php
namespace Modules\Company\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Modules\Core\Models\SEO;
use Modules\Candidate\Models\Category;
use Modules\Core\Models\Terms;
use Modules\Job\Models\Job;
use Modules\Location\Models\Location;
use Modules\Core\Models\Attributes;

class CompanyTerm extends BaseModel
{
    protected $table = 'bc_company_term';
    protected $fillable = [
        'term_id',
        'company_id'
    ];
    public function term()
    {
        return $this->hasOne(Terms::class, 'id', 'term_id')->with(['translations']);
    }
}
