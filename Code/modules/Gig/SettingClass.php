<?php

namespace  Modules\Gig;

use Modules\Core\Abstracts\BaseSettingsClass;
use Modules\Core\Models\Settings;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        return [
            [
                'id'   => 'gig',
                'title' => __("Gig Settings"),
                'position'=>20,
                'view'=>"Gig::admin.settings.gig",
                "keys"=>[
                    'gig_disable',
                    'gig_page_search_title',
                    'gig_page_search_banner',
                    'gig_page_limit_item',

                    'gig_enable_review',
                    'gig_review_number_per_page',
                    'gig_review_stats',

                    'gig_page_list_seo_title',
                    'gig_page_list_seo_desc',
                    'gig_page_list_seo_image',
                    'gig_page_list_seo_share',
                    'gig_booking_buyer_fees',


                    'vendor_commission_type',
                    'vendor_commission_amount',

                    'gig_booking_type',
                    'gig_icon_marker_map',
                    'gig_days_complete_order',
                    'gig_max_posts'

                ],
                'html_keys'=>[

                ]
            ]
        ];
    }
}
