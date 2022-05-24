<?php
namespace Modules\User\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\AdminController;
use Modules\User\Helpers\PermissionHelper;
use \Modules\User\Models\Role;

class RoleController extends AdminController
{
    protected $role_class;
    public function __construct()
    {
        parent::__construct();
        $this->role_class = Role::class;
    }

    public function index()
    {
        $this->checkPermission('role_manage');
        $data = [
            'rows' => Role::paginate(20)
        ];
        return view('User::admin.role.index', $data);
    }

    public function create(Request $request)
    {
        if (!empty($request->input())) {

        } else {
            $row = new User();
            $row->fill([
                'status' => 'publish'
            ]);
        }
        $data = [
            'row' => $row
        ];
        return view('User::admin.role.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('role_manage');
        $row = Role::find((int)$id);
        if (empty($row)) {
            return redirect('admin/module/user/role');
        }
        if (!empty($request->input())) {
            $row->fill($request->input());
            if ($row->save()) {

                return redirect('admin/module/user/role')->with('success', __('Role updated'));
            }
        }
        $data = [
            'row' => $row
        ];
        return view('User::admin.role.detail', $data);
    }

    public function store(Request $request, $id){
        if($id>0){
            $this->checkPermission('role_manage');
            $row = Role::find((int)$id);
            if (empty($row)) {
                return redirect(route('user.admin.role.index'));
            }
        }else{
            $this->checkPermission('role_manage');
            $row = new Role();
        }
        $request->validate([
            'code'=> [
                'required',
                'max:255',
                'min:4',
                'string',
                'alpha_dash',
                Rule::unique('core_roles')->ignore($row->code)
            ],
        ]);

        $row->fill($request->input());
        $res = $row->save();
        if ($res) {
            if($id > 0 ){
                return back()->with('success',  __('Role updated') );
            }else{
                return redirect(route('user.admin.role.detail',['id' => $row->id]))->with('success', __('Role created') );
            }
        }
    }

    public function verifyFields(Request $request){

        $this->checkPermission('role_manage');
        $this->setActiveMenu('admin/module/user');

        $data = [
            'roles' => Role::all(),
            'fields'=>setting_item_array('role_verify_fields'),
            'breadcrumbs' => [
                [
                    'name' => __('User'),
                    'url'  => 'admin/module/user'
                ],
                [
                    'name' => __('Role Management'),
                    'url'  => 'admin/module/user/role'
                ],
                [
                    'name' => __('Verify Configs'),
                    'url'  => 'admin/module/user/role/verifyFields',
                    'active'=>1
                ],
            ]
        ];
        return view('User::admin.role.verifyFields', $data);

    }
    public function verifyFieldsEdit(Request $request,$id){

        $this->checkPermission('role_manage');

        $this->setActiveMenu('admin/module/user');

        $all = setting_item_array('role_verify_fields');
        $row = $all[$id] ?? [];

        if(empty($row)) return redirect()->back()->with("error",__("Field not found"));

        $row['id'] = $id;

        $data = [
            'roles' => Role::all(),
            'row'=>$row,
            'breadcrumbs' => [
                [
                    'name' => __('User'),
                    'url'  => 'admin/module/user'
                ],
                [
                    'name' => __('Role Management'),
                    'url'  => 'admin/module/user/role'
                ],
                [
                    'name' => __('Verify Configs'),
                    'url'  => 'admin/module/user/role/verifyFields',
                ],
                [
                    'name' => __('Edit field: :name',['name'=>$row['name'] ?? $id]),
                    'active'=>1
                ],
            ]
        ];
        return view('User::admin.role.verifyFieldsEdit', $data);

    }

    public function verifyFieldsStore(){
        $this->checkPermission('role_manage');

        $all = setting_item_array('role_verify_fields',[]);
        $id = \request()->input('id');
        $id = Str::snake($id);
        if(empty($id))
        {
            return redirect()->back()->withInput();
        }
        $isAdd = !isset($all[$id]);
        $all[$id] = [
            'name'=>\request()->input('name'),
            'type'=>\request()->input('type'),
            'roles'=>\request()->input('roles'),
            'required'=>\request()->input('required'),
            'order'=>\request()->input('order'),
            'icon'=>\request()->input('icon'),
        ];

        $languages = \Modules\Language\Models\Language::getActive();
        if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
        {
            foreach($languages as $language){
                $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : "";
                $all[$id]['name'.$key_lang] = \request()->input('name'.$key_lang);
            }
        }

        setting_update_item('role_verify_fields',$all);

        return redirect()->back()->with('success', $isAdd? __("Field created") : __("Field saved"));
    }

	public function bulkEdit(Request $request)
	{
		$ids = $request->input('ids');
		$action = $request->input('action');
		if (empty($ids))
			return redirect()->back()->with('error', __('Select at leas 1 item!'));
		if (empty($action))
			return redirect()->back()->with('error', __('Select an Action!'));
		if ($action == 'delete') {
			$all = setting_item_array('role_verify_fields',[]);
			$new = Arr::except($all,$ids);
			setting_update_item('role_verify_fields',$new);
		}
		return redirect()->back()->with('success', __('Updated successfully!'));
	}


	public function permission_matrix()
    {
        $permissions = PermissionHelper::all();
        $permissions_group = [
            'other' => []
        ];
        if (!empty($permissions)) {
            foreach ($permissions as $permission) {
                $sCheck = strpos($permission, '_');
                if ($sCheck == false) {
                    $permissions_group['other'][] = $permission;
                    continue;
                }
                $grName = substr($permission, 0, $sCheck);
                if (!isset($permissions_group[$grName]))
                    $permissions_group[$grName] = [];
                $permissions_group[$grName][] = $permission;
            }
        }
        if (empty($permissions_group['other'])) {
            unset($permissions_group['other']);
        }
        $roles = Role::all();
        $selectedIds = [];
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $selectedIds[$role->id] = $role->permissions->pluck('permission')->all();
            }
        }

        $data = [
            'permissions'       => $permissions,
            'roles'             => $roles,
            'permissions_group' => $permissions_group,
            'selectedIds'       => $selectedIds,
            'role'              => $role
        ];
        return view('User::admin.role.permission_matrix', $data);
    }

    public function save_permissions(Request $request)
    {
        $matrix = $request->input('matrix');
        $matrix = is_array($matrix) ? $matrix : [];
        if (!empty($matrix)) {
            foreach ($matrix as $role_id => $permissions) {
                $role = Role::find($role_id);
                if (!empty($role)) {
                    $role->syncPermissions($permissions);
                }
            }
        }
        return redirect()->back()->with('success', __('Permission Matrix updated'));
    }

    public function getForSelect2(Request $request)
    {
        $pre_selected = $request->query('pre_selected');
        $selected = $request->query('selected');

        if($pre_selected && $selected){
            $item = $this->role_class::where('name',$selected)->first();
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
        $query = $this->role_class::select('name as id', 'name as text');
        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }
        $res = $query->orderBy('id', 'desc')->limit(20)->get();
        return response()->json([
            'results' => $res
        ]);
    }
}
