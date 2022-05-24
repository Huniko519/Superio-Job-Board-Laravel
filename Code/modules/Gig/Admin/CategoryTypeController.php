<?php
namespace Modules\Gig\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Gig\Models\GigCategory;
use Modules\Gig\Models\GigCategoryTranslation;
use Modules\Gig\Models\GigCategoryType;

class CategoryTypeController extends AdminController
{
    protected $categoryClass;
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu(route('gig.admin.index'));
        $this->categoryClass = GigCategoryType::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('gig_manage_others');
        $listCategory = $this->categoryClass::query();
        if (!empty($search = $request->query('s'))) {
            $listCategory->where('name', 'LIKE', '%' . $search . '%');
        }
        $listCategory->orderBy('created_at', 'desc');
        $data = [
            'rows'        => $listCategory->paginate(20),
            'row'         => new $this->categoryClass(),
            'translation'    => new GigCategoryTranslation(),
            'breadcrumbs' => [
                [
                    'name' => __('Gigs'),
                    'url'  => route('gig.admin.index')
                ],
                [
                    'name'  => __('Category Type'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Gig::admin.category_type.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('gig_manage_others');
        $row = $this->categoryClass::find($id);
        if (empty($row)) {
            return redirect(route('gig.admin.category_type.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        $data = [
            'translation'    => $translation,
            'enable_multi_lang'=>true,
            'row'         => $row,
            'breadcrumbs' => [
                [
                    'name' => __('Gigs'),
                    'url'  => route('gig.admin.index')
                ],
                [
                    'name'  => __('Category Type'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Gig::admin.category_type.detail', $data);
    }

    public function store(Request $request , $id)
    {
        $this->checkPermission('gig_manage_others');
        $this->validate($request, [
            'name' => 'required'
        ]);

        if($id>0){
            $row = $this->categoryClass::find($id);
            if (empty($row)) {
                return redirect(route('gig.admin.category_type.index'));
            }
        }else{
            $row = new $this->categoryClass();
            $row->status = "publish";
        }

        $row->fillByAttr([
            'name',
            'cat_id',
            'cat_children',
            'image_id',
        ],$request->input());

        $res = $row->saveOriginOrTranslation($request->input('lang'),true);

        if ($res) {
            return back()->with('success',  __('Type saved') );
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('gig_manage_others');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('Select at least 1 item!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $this->categoryClass::where("id", $id)->first();
                if(!empty($query)){
                    //Sync child category
                    $list_childs = $this->categoryClass::where("parent_id", $id)->get();
                    if(!empty($list_childs)){
                        foreach ($list_childs as $child){
                            $child->parent_id = null;
                            $child->save();
                        }
                    }
                    //Del parent category
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->categoryClass::where("id", $id);
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            $item = $this->categoryClass::find($selected);
            if(empty($item)){
                return response()->json([
                    'text'=>''
                ]);
            }else{
                return response()->json([
                    'text'=>$item->name
                ]);
            }
        }
        $q = $request->query('q');
        $query = $this->categoryClass::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
