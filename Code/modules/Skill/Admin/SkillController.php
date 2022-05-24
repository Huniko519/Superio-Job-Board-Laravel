<?php
namespace Modules\Skill\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Skill\Models\Skill;
use Modules\Skill\Models\SkillTranslation;

class SkillController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu('admin/module/skill');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->checkPermission('skill_manage_others');
        $listSkill = Skill::query() ;
        if (!empty($search = $request->query('s'))) {
            $listSkill->where('name', 'LIKE', '%' . $search . '%');
        }
        $listSkill->orderBy('created_at', 'asc');
        $data = [
            'rows'        => $listSkill->get(),
            'row'         => new Skill(),
            'translation' => new SkillTranslation(),
            'breadcrumbs' => [
                [
                    'name' => __('Skill'),
                    'url'  => 'admin/module/skill'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Skill::admin.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('skill_manage_others');
        $row = Skill::find($id);
        $translation = $row->translateOrOrigin($request->query('lang'));
        if (empty($row)) {
            return redirect('admin/module/skill');
        }
        $data = [
            'translation' => $translation,
            'enable_multi_lang'=>true,
            'row'         => $row,
            'breadcrumbs' => [
                [
                    'name' => __('Skill'),
                    'url'  => 'admin/module/skill'
                ],
                [
                    'name'  => __('Edit'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Skill::admin.detail', $data);
    }

    public function store( Request $request, $id ){
        $this->checkPermission('skill_manage_others');
        $this->validate($request, [
            'name' => 'required'
        ]);
        if($id>0){
            $row = Skill::find($id);
            if (empty($row)) {
                return redirect(route('skill.admin.index'));
            }
        }else{
            $row = new Skill();
        }
        $attr = [
            'name',
            'status'
        ];
        $row->fillByAttr($attr, $request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'),false);

        if ($res) {
            if($id > 0 ){
                return back()->with('success',  __('Skill updated') );
            }else{
                return back()->with('success', __('Skill created') );
            }
        }
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            if(is_array($selected))
            {
                $items = Skill::select('id', 'name as text')->whereIn('id',$selected)->take(50)->get();
                return response()->json([
                    'items'=>$items
                ]);
            }else{
                $item = Skill::find($selected);
            }
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
        $query = Skill::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __("Select at least 1 item!"));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Select an Action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = Skill::where("id", $id);
                if (!$this->hasPermission('skill_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('skill_delete');
                }
                $query->first();
                if(!empty($query)){
                    //Del parent skill
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = Skill::where("id", $id);
                if (!$this->hasPermission('skill_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('skill_update');
                }
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Updated success!'));
    }
}
