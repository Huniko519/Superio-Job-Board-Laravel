<?php
namespace Modules\Job\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Job\Models\JobType;
use Modules\Job\Models\JobTypeTranslation;

class JobTypeController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/job');
    }

    public function index(Request $request)
    {
        $this->checkPermission('job_manage_others');
        $listTypes = JobType::query();
        if (!empty($search = $request->query('s'))) {
            $listTypes->where('name', 'LIKE', '%' . $search . '%');
        }
        $listTypes->orderBy('created_at', 'desc');
        $data = [
            'rows'        => $listTypes->get(),
            'row'         => new JobType(),
            'translation'    => new JobTypeTranslation(),
            'breadcrumbs' => [
                [
                    'name' => __('Job'),
                    'url'  => 'admin/module/job'
                ],
                [
                    'name'  => __('Job Type'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Job::admin.job-type.index', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('job_manage_others');
        $row = JobType::find($id);
        if (empty($row)) {
            return redirect(route('job.admin.type.index'));
        }
        $translation = $row->translateOrOrigin($request->query('lang'));
        $data = [
            'translation'    => $translation,
            'enable_multi_lang'=>true,
            'row'         => $row,
            'parents'     => JobType::get(),
            'breadcrumbs' => [
                [
                    'name' => __('Job'),
                    'url'  => 'admin/module/job'
                ],
                [
                    'name'  => __('Job Type'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Job::admin.job-type.detail', $data);
    }

    public function store(Request $request , $id)
    {
        $this->checkPermission('job_manage_others');
        $this->validate($request, [
            'name' => 'required'
        ]);
        if($id>0){
            $row = JobType::find($id);
            if (empty($row)) {
                return redirect(route('job.admin.type.index'));
            }
        }else{
            $row = new JobType();
        }

        $row->fill($request->input());
        $res = $row->saveOriginOrTranslation($request->input('lang'),true);


        if ($res) {
            return back()->with('success',  __('Job type saved') );
        }
    }

    public function editBulk(Request $request)
    {
        $this->checkPermission('job_manage_others');
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
                $query = JobType::where("id", $id)->first();
                if(!empty($query)){
                    //Del parent type
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = JobType::where("id", $id);
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
            $item = JobType::find($selected);
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
        $query = JobType::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
