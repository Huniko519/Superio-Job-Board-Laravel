<?php
namespace Modules\Company\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Candidate\Models\CandidateContact;
use Modules\Company\Models\CompanyTerm;
use Modules\Language\Models\Language;
use Modules\Company\Models\CompanyCategory as Category;
use Modules\Company\Models\Company;
use Modules\Company\Models\CompanyTranslation;
use Modules\Location\Models\Location;
use Modules\Core\Models\Attributes;

class CompanyController extends AdminController
{
    protected $attributes;
    protected $location;
    protected $company;
    protected $company_translation;
    protected $category;
    protected $language;
    protected $company_term;

    public function __construct()
    {
        $this->setActiveMenu('admin/module/company');
        if(!is_admin()){
            $this->middleware('verified');
        }
        parent::__construct();
        $this->attributes = Attributes::class;
        $this->company = Company::class;
        $this->location = Location::class;
        $this->category = Category::class;
        $this->company_translation = CompanyTranslation::class;
        $this->language = Language::class;
        $this->company_term = CompanyTerm::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('employer_manage');
        if(!is_admin())
        {
            $user_company = $this->company::where('owner_id',Auth::id())->first();
            if($user_company)
            {
                return redirect(route('company.admin.edit',['id'=>$user_company->id]));
            }else{
                return redirect(route('company.admin.create'));
            }
        }
        $dataCompany = $this->company::query()->orderBy('id', 'desc');
        $company_name = $request->query('s');
        $cate = $request->query('category_id');
        if ($cate) {
            $dataCompany->where('category_id', $cate);
        }
        if ($company_name) {
            $dataCompany->where('name', 'LIKE', '%' . $company_name . '%');
            $dataCompany->orderBy('name', 'asc');
        }

        $data = [
            'rows'        => $dataCompany->paginate(20),
            'categories'  => $this->category::get(),
            'breadcrumbs' => [
                [
                    'name' => __('Company'),
                    'url'  => 'admin/module/company'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            "languages"=>$this->language::getActive(false),
            "locale"=>\App::getLocale(),
            'page_title'=>__("Company Management")
        ];
        return view('Company::admin.company.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('employer_manage');
        if(!is_admin())
        {
            $user_company = $this->company::where('owner_id',Auth::id())->first();
            if($user_company)
            {
                return redirect(route('company.admin.edit',['id'=>$user_company->id]));
            }
        }
        $row = new $this->company();
        $row->fill([
            'status' => 'publish',
        ]);
        $data = [
            'categories'        => $this->category::get()->toTree(),
            'attributes'     => $this->attributes::where('service', 'company')->get(),
            'row'         => $row,
            'company_location'     => $this->location::where('status', 'publish')->get()->toTree(),
            'breadcrumbs' => [
                [
                    'name' => __('Company'),
                    'url'  => 'admin/module/company'
                ],
                [
                    'name'  => __('Add Company'),
                    'class' => 'active'
                ],
            ],
            'page_title'=>__("Add new Company"),
            'translation'=>new $this->company_translation()
        ];
        return view('Company::admin.company.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('employer_manage');

        $row = $this->company::find($id);

        $translation = $row->translateOrOrigin($request->query('lang'));

        if (empty($row)) {
            return redirect(route('company.admin.index'));
        }elseif(!is_admin() && $row->owner_id != Auth::id()){
            $user_company = $this->company::where('owner_id',Auth::id())->first();
            if($user_company)
            {
                return redirect(route('company.admin.edit',['id'=>$user_company->id]));
            }else{
                return redirect(route('company.admin.create'));
            }
        }

        $data = [
            'row'  => $row,
            'categories'        => $this->category::get()->toTree(),
            'attributes'     => $this->attributes::where('service', 'company')->get(),
            'company_location'     => $this->location::where('status', 'publish')->get()->toTree(),
            'translation'  => $translation,
            'enable_multi_lang'=>true,
            'page_title'=>__("Edit Company :name",['name'=>$translation->name]),
            "selected_terms"    => $row->companyTerm ? $row->companyTerm->pluck('term_id') : [],
        ];
        return view('Company::admin.company.detail', $data);
    }

    public function store(Request $request, $id){

        $this->checkPermission('employer_manage');
        $input = $request->input();

        if($id>0){
            $row = $this->company::find($id);
            if (empty($row)) {
                return redirect(route('company.admin.index'));
            }elseif(!is_admin() && $row->owner_id != Auth::id()){
                $user_company = $this->company::where('owner_id',Auth::id())->where('status','publish')->first();
                if($user_company)
                {
                    return redirect(route('company.admin.edit',['id'=>$user_company->id]));
                }else{
                    return redirect(route('company.admin.create'));
                }
            }
        }else{
            $row = new $this->company();
            if(!is_admin())
            {
                $user_company = $this->company::where('owner_id',Auth::id())->where('status','publish')->first();
                if($user_company)
                {
                    return redirect(route('company.admin.edit',['id'=>$user_company->id]));
                }
                $row->owner_id = Auth::id();
            }
        }
        $attr = [
            'name',
            'email',
            'phone',
            'website',
            'location_id',
            'avatar_id',
            'founded_in',
            'category_id',
            'map_lat',
            'map_lng',
            'status',
            'about',
            'social_media',
            'city',
            'state',
            'country',
            'address',
            'team_size',
            'is_featured',
            'zip_code',
            'allow_search'
        ];
        $input['team_size'] = !empty($input['team_size']) ? $input['team_size'] : 0;

        $row->fillByAttr($attr, $input);
        if($request->input('slug')){
            $row->slug = $request->input('slug');
        }
        if(is_admin())
        {
            $row->owner_id = $input['owner_id'] ?? Auth::id();
            $row->is_featured = $input['is_featured'] ?? 0;
        }
        $res = $row->saveOriginOrTranslation($request->query('lang'),true);

        if ($res) {
            if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                $this->saveTerms($row, $request);
            }
            if($id > 0 ){
                return back()->with('success',  __('Company updated') );
            }else{
                return redirect(route('company.admin.edit',$row->id))->with('success', __('Company created') );
            }
        }
    }

    public function saveTerms($row, $request)
    {
        if (empty($request->input('terms'))) {
            $this->company_term::where('company_id', $row->id)->delete();
        } else {
            $term_ids = $request->input('terms');
            foreach ($term_ids as $term_id) {
                $this->company_term::firstOrCreate([
                    'term_id' => $term_id,
                    'company_id' => $row->id
                ]);
            }
            $this->company_term::where('company_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
        }
    }

    public function bulkEdit(Request $request)
    {
        $this->checkPermission('employer_manage_others');
        $ids = $request->input('ids'); dd($ids);
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = $this->company::where("id", $id);
                if (!$this->hasPermission('employer_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('employer_manage');
                }
                $query->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->company::where("id", $id);
                if (!$this->hasPermission('employer_manage_others')) {
                    $query->where("create_user", Auth::id());
                    $this->checkPermission('employer_manage');
                }
                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }

    public function trans($id,$locale){
        $row = $this->company::find($id);

        if(empty($row)){
            return redirect()->back()->with("danger",__("Company does not exists"));
        }

        $translated = $this->company::query()->where('origin_id',$id)->where('lang',$locale)->first();
        if(!empty($translated)){
            redirect($translated->getEditUrl());
        }

        $language = $this->language::where('locale',$locale)->first();
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

    public function getForSelect2(Request $request)
    {
        $q = $request->query('q');
        $query = Company::select('id', 'name as text')->where("status","publish");
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }

    function myContact(Request $request){
        $this->setActiveMenu('admin/module/company/my-contact');
        $query = CandidateContact::query()
            ->where('contact_to', 'company')
            ->where('origin_id', Auth::id());

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
        return view('Company::admin.company.my-contact', $data);
    }
}
