<?php
namespace Modules\Core\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\AdminController;
use Modules\Core\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingsController extends AdminController
{
    protected $groups = [];

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/core/settings/index/general');
    }

    public function index($group)
    {

        if(empty($this->groups)){
            $this->setGroups();
        }

        $this->checkPermission('setting_manage');
        $settingsGroupKeys = array_keys($this->groups);
        if (empty($group) or !in_array($group, $settingsGroupKeys)) {
            $group = $settingsGroupKeys[0];
        }
        $data = [
            'current_group' => $group,
            'groups'        => $this->groups,
            'settings'      => Settings::getSettings(),
            'breadcrumbs'   => [
                ['name' => $this->groups[$group]['name'] ?? $this->groups[$group]['title'] ?? ''],
            ],
            'page_title'    => $this->groups[$group]['name'] ?? $this->groups[$group]['title'] ?? $group,
            'group'         => $this->groups[$group],
            'enable_multi_lang'=>true
        ];
        return view('Core::admin.settings.index', $data);
    }

    public function store(Request $request, $group)
    {

        if(empty($this->groups)){
            $this->setGroups();
        }

        $this->checkPermission('setting_manage');
        $settingsGroupKeys = array_keys($this->groups);
        if (empty($group) or !in_array($group, $settingsGroupKeys)) {
            $group = $settingsGroupKeys[0];
        }
        $group_data = $this->groups[$group];
        $keys = [];
        $htmlKeys = [];
        $filter_demo_mode = [];
        switch ($group) {
            case 'general':
                $keys = [
                    'site_title',
                    'site_desc',
                    'site_favicon',
                    'phone_contact',
                    'home_page_id',
                    'logo_id',
                    'logo_white_id',
                    'footer_style',
                    'copyright',
                    'footer_socials',
                    'footer_info_text',
                    'list_widget_footer',
                    'date_format',
                    'site_timezone',
                    'site_locale',
                    'site_first_day_of_the_weekin_calendar',
                    'site_enable_multi_lang',
                    'enable_rtl',
                    'page_contact_lists',
                    'page_contact_iframe_google_map',
                    'contact_call_to_action_title',
                    'contact_call_to_action_sub_title',
                    'contact_call_to_action_button_text',
                    'contact_call_to_action_button_link',
                    'contact_call_to_action_image',
                    'enable_preloader',
                    'terms_and_conditions_id',
                ];
                $filter_demo_mode = [
                    'home_page_id',
                    'admin_email',
                    'email_from_name',
                    'email_from_address',
                    'footer_text_left',
                    'footer_text_right',
                    'site_title',
                    'site_desc',
                    'logo_id',
                ];
                break;
            case 'style':
                $keys = [
                    'style_main_color',
                    'style_custom_css',
                    'style_typo',
                ];
                $filter_demo_mode = [
                    'style_custom_css',
                    'style_typo',
                ];
                Settings::clearCustomCssCache();
                break;
        }
        if(!empty($group_data['keys'])) $keys = $group_data['keys'];
        if(!empty($group_data['html_keys'])) $htmlKeys = $group_data['html_keys'];

        $filter_demo_mode = $group_data['filter_demo_mode'] ?? $filter_demo_mode;
        if(!is_demo_mode()){
            $filter_demo_mode = [];
        }

        $lang = $request->input('lang');
        if(is_default_lang($lang)) $lang = false;


        if (!empty($request->input())) {
            if (!empty($keys)) {
                $all_values = $request->input();
                //If we found callback validate data before save
                if(!empty($group_data['filter_values_callback']) and is_callable($group_data['filter_values_callback']))
                {
                    $all_values = call_user_func($group_data['filter_values_callback'],$all_values,$request);
                }


                foreach ($keys as $key) {
                    if(in_array($key,$filter_demo_mode)){
                        continue;
                    }
                    $setting_key = $key.($lang ? '_'.$lang : '');

	                $val = $all_values[$key] ?? '';
	                if (is_array($val)) {
		                $val = json_encode($val);
	                }
	                if (in_array($key, $htmlKeys)) {
		                $val = clean($val);
	                }
	                Settings::updateOrCreate(
			                ['name'=>$setting_key],
			                ['val'=>$val]
	                );
                    Cache::forget('setting_' . $setting_key);
                }
            }
            //Clear Cache for currency
            Session::put('bc_current_currency',"");
            return redirect()->back()->with('success', __('Settings Saved'));
        }
    }


    protected function setGroups(){

        $all = Settings::getSettingPages();

        $res = [];

        if(!empty($all))
        {
            foreach ($all as $item){
                $res[$item['id']] = $item;
            }
        }
        $this->groups = $res;
    }
}
