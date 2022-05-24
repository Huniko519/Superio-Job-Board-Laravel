<?php
namespace Modules\Gig\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\News\Models\Tag;

class GigTag extends BaseModel
{
    protected $table = 'bc_gig_tags';
    protected $fillable = [
        'target_id',
        'tag_id'
    ];

    public static function getModelName()
    {
        return __("Gig Tag");
    }

    public static function searchForMenu($q = false)
    {

    }

    public function tag()
    {
        return $this->belongsTo(Tag::class,'tag_id');
    }

    public static function getAll()
    {
        return self::with('tag')->get();
    }

    public static function addTag($tags_ids, $news_id)
    {
        if (!empty($tags_ids)) {
            foreach ($tags_ids as $tag_id) {
                $find = parent::where('target_id', $news_id)->where('tag_id', $tag_id)->first();
                if (empty($find)) {

                    $a = new self();
                    $a->target_id = $news_id;
                    $a->tag_id = $tag_id;
                    $a->save();
                }
            }
        }
    }

    public static function getTags(){

        $query = Tag::query()->with('translations');

        $query->select(['core_tags.*']);

        return $query
            ->join('bc_gig_tags as nt','nt.tag_id','=','core_tags.id')->orderByRaw('RAND()')
            ->groupBy('core_tags.id')
            ->get(10);

    }
}
