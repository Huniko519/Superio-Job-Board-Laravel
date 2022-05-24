<?php
namespace  Modules\Candidate;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'candidate',
                'title' => __("Candidate Settings"),
                'position'=>30,
                'view'=>"Candidate::admin.settings.candidate",
                "keys"=>[
                    'candidate_page_search_title',
                    'candidate_download_cv_required_login',
                    'candidate_limit_apply_by',
                    'candidate_maximum_job_apply',
                    'candidates_list_layout',
                    'single_candidate_layout',
                    'candidate_sidebar_search_fields',
                    'candidate_location_search_style',
                    'candidate_page_list_seo_title',
                    'candidate_page_list_seo_desc',
                    'candidate_page_list_seo_image',
                    'candidate_page_list_seo_share',
                    'candidate_sidebar_cta',
                    'candidate_single_layout',
                    'candidate_list_layout'
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
