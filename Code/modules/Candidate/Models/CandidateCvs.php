<?php
namespace Modules\Candidate\Models;

use App\BaseModel;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\SEO;
use Modules\Media\Models\MediaFile;

class CandidateCvs extends BaseModel
{
    protected $table = 'bc_candidate_cvs';

    protected $fillable = [
        'file_id',
        'origin_id',
        'is_default',
        'create_user',
        'update_user'
    ];

    public function media(){
        return $this->hasOne(MediaFile::class, 'id', 'file_id');
    }
}
