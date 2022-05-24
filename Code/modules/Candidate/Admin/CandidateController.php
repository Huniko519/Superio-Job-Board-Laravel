<?php
namespace Modules\Candidate\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Candidate\Models\CandidateContact;
use Modules\Job\Events\CandidateDeleteApplied;
use Modules\Job\Models\JobCandidate;
use Modules\Language\Models\Language;
use Modules\Candidate\Models\Category;
use Modules\Candidate\Models\Candidate;
use Modules\User\Models\User;

class CandidateController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu('admin/module/candidate');
        if(!is_admin()){
            $this->middleware('verified');
        }
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->checkPermission('candidate_manage_others');
        $username = $request->query('s');
        $cate_id = $request->query('cate_id');
        $listUser = \App\User::query()->where('role_id',3);
        if (!empty($username)) {
            $listUser->where(function($query) use($username){
                $query->where('first_name', 'LIKE', '%' . $username . '%');
                $query->orWhere('id',  $username);
                $query->orWhere('phone',  $username);
                $query->orWhere('email', 'LIKE', '%' . $username . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $username . '%');
            });
        }

        if (!empty($cate_id)) {
            $listUser->whereHas(
                'candidate.categories', function($q) use ($cate_id){
                $q->where('bc_candidate_categories.cat_id', $cate_id);
            });
        }

        if (!empty($request->query('status'))) {
            $listUser->where('status',  $request->query('status'));
        }

        if (!empty($request->query('allow_search'))) {
            $allow_search = $request->query('allow_search');
            $listUser->whereHas(
                'candidate', function($q) use ($allow_search){
                $q->where('allow_search', $allow_search);
            });
        }

        $listUser->orderBy('id','desc');

        //$this->filterLang($dataCandidate);

        $data = [
            'rows'        => $listUser->paginate(20),
            'categories'  => Category::get(),
            'breadcrumbs' => [
                [
                    'name' => __('Candidate'),
                    'url'  => 'admin/module/candidate'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            "locale"=>\App::getLocale(),
            'page_title'=>__("Candidate Management")
        ];
        return view('Candidate::admin.candidate.index', $data);
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('candidate_manage_others');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                if($id == Auth::id()) continue;
                $query = \App\User::where("id", $id)->first();
                $candidate = Candidate::where("id", $id)->first();
                if(!empty($query)){
                    $query->email.='_d_'.uniqid().rand(0,99999);
                    $query->save();
                    $query->delete();

                    if(!empty($candidate)){
                        $candidate->delete();
                    }
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = Candidate::where("id", $id);
                if (!$this->hasPermission('candidate_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('candidate_manage');
                }
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function trans($id,$locale){
        $row = Candidate::find($id);

        if(empty($row)){
            return redirect()->back()->with("danger",__("Candidate does not exists"));
        }

        $translated = Candidate::query()->where('origin_id',$id)->where('lang',$locale)->first();
        if(!empty($translated)){
            redirect($translated->getEditUrl());
        }

        $language = Language::where('locale',$locale)->first();
        if(empty($language)){
            return redirect()->back()->with("danger",__("Language does not exists"));
        }

        $new = $row->replicate();

        if(!$row->origin_id){
            $new->origin_id = $row->id;
        }

        $new->lang = $locale;

        $new->save();


        return redirect($new->getEditUrl());
    }

    function myApplied(Request $request){
        $this->setActiveMenu('admin/module/candidate/my-applied');
        $query = JobCandidate::with(['jobInfo', 'candidateInfo', 'cvInfo'])->where('candidate_id', Auth::id());
        if($s = $request->get('s')){
            $query->whereHas('jobInfo', function ($q) use ($s){
                $q->where("title", 'like', '%'.$s.'%');
            });
        }
        if($status = $request->get('status')){
            $query->where('status', $status);
        }
        if($orderby = $request->get('orderby')){
            switch ($orderby){
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }else{
            $query->orderBy('id', 'desc');
        }

        $rows = $query->paginate(20);
        $data = [
            'rows' => $rows
        ];
        return view('Candidate::admin.candidate.my-applied', $data);
    }

    public function deleteJobApplied(Request $request, $id){
        $this->checkPermission('candidate_manage');
        $row = JobCandidate::with('jobInfo', 'jobInfo.user', 'candidateInfo', 'company')
            ->where('candidate_id', Auth::id())
            ->where('id', $id)
            ->first();
        if (empty($row)) {
            return redirect()->back()->with('error', __('Item not found!'));
        }
        if($row->status != 'pending') {
            return redirect()->back()->with('error', __("Can't delete this item"));
        }
        //Send Email and Notify
        event(new CandidateDeleteApplied($row));

        $row->delete();

        return back()->with('success',  __('Delete successfully!') );
    }

    function myContact(Request $request){
        $this->setActiveMenu('admin/module/candidate/my-contact');
        $query = CandidateContact::query()
            ->where(function($q){
                $q->whereNull('contact_to')
                    ->orWhere('contact_to', 'candidate');
            })->where('origin_id', Auth::id());

        if($orderby = $request->get('orderby')){
            switch ($orderby){
                case 'oldest':
                    $query->orderBy('id', 'asc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        }else{
            $query->orderBy('id', 'desc');
        }

        $rows = $query->paginate(20);
        $data = [
            'rows' => $rows
        ];
        return view('Candidate::admin.candidate.my-contact', $data);
    }

    public function getForSelect2(Request $request)
    {
        $s = $request->query('q');
        $listUser = \App\User::query()->whereHas(
            'role', function($q){
            $q->where('id', 3);
        });
        if (!empty($s)) {
            $listUser->where(function($query) use($s){
                $query->where('first_name', 'LIKE', '%' . $s . '%');
                $query->orWhere('last_name', 'LIKE', '%' . $s . '%');
            });
        }

        $res = $listUser->orderBy('id', 'desc')->limit(20)->get();
        $data = [];
        if(!empty($res) && count($res) > 0){
            foreach($res as $key => $val){
                $data[] = [
                    'id' => $val->id,
                    'text' => $val->getDisplayName()
                ];
            }
        }

        return response()->json([
            'results' => $data
        ]);
    }

}
