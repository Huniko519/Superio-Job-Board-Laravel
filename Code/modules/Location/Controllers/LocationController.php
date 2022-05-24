<?php
namespace Modules\Location\Controllers;

use App\Http\Controllers\Controller;
use Modules\Location\Models\Location;
use Illuminate\Http\Request;
use Modules\News\Models\News;

class LocationController extends Controller
{
    public $location;
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function index(Request $request)
    {

    }

    public function detail(Request $request, $slug)
    {
        $row = $this->location::where('slug', $slug)->where("status", "publish")->first();
        if (empty($row)) {
            return redirect('/');
        }

        $translation = $row->translateOrOrigin(app()->getLocale());
        $recent_articles = News::orderBy('id','DESC')->limit(4)->get();
        $data = [
            'row' => $row,
            'translation' => $translation,
            'seo_meta' => $row->getSeoMetaWithTranslation(app()->getLocale(), $translation),
            'articles' => $recent_articles,
            'is_home' => true
        ];
        $this->setActiveMenu($row);
        return view('Location::frontend.detail', $data);
    }

    public function searchForSelect2( Request $request ){
        $search = $request->query('search');
        $query = Location::select('bc_locations.*', 'bc_locations.name as title')->where("bc_locations.status","publish");
        if ($search) {
            $query->where('bc_locations.name', 'like', '%' . $search . '%');

            if( setting_item('site_enable_multi_lang') && setting_item('site_locale') != app()->getLocale() ){
                $query->leftJoin('bc_location_translations', function ($join) use ($search) {
                    $join->on('bc_locations.id', '=', 'bc_location_translations.origin_id');
                });
                $query->orWhere(function($query) use ($search) {
                    $query->where('bc_location_translations.name', 'LIKE', '%' . $search . '%');
                });
            }

        }
        $res = $query->orderBy('name', 'asc')->limit(20)->get();
        if(!empty($res) and count($res)){
            $list_json = [];
            foreach ($res as $location) {
                $translate = $location->translateOrOrigin(app()->getLocale());
                $list_json[] = [
                    'id' => $location->id,
                    'title' => $translate->name,
                ];
            }
            return $this->sendSuccess(['data'=>$list_json]);
        }
        return $this->sendError(__("Location not found"));
    }
}
