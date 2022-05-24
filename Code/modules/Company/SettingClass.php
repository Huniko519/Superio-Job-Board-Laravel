<?php
namespace  Modules\Company;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'company',
                'title' => __("Company Settings"),
                'position' => 30,
                'view'=>"Company::admin.settings.company",
                "keys"=>[
                    'company_page_search_title',
                    'company_list_layout',
                    'single_company_layout',
                    'company_sidebar_search_fields',
                    'company_location_search_style',
                    'company_page_list_seo_title',
                    'company_page_list_seo_desc',
                    'company_page_list_seo_image',
                    'company_page_list_seo_share',
                    'company_sidebar_cta',
                    'enable_hide_email_company',
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
