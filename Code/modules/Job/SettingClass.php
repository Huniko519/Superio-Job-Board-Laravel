<?php
namespace  Modules\Job;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'job',
                'title' => __("Job Settings"),
                'position' => 30,
                'view'=>"Job::admin.settings.job",
                "keys"=>[
                    'job_page_search_title',
                    'jobs_list_layout',
                    'job_single_layout',
                    'job_sidebar_search_fields',
                    'job_banner_search_fields',
                    'job_location_search_style',
                    'job_page_list_seo_title',
                    'job_page_list_seo_desc',
                    'job_page_list_seo_image',
                    'job_page_list_seo_share',
                    'job_sidebar_cta',
                    'job_require_plan',
                    'job_hide_expired_jobs',
                    'job_company_max_post_jobs'
                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
