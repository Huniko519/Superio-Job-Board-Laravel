<?php

	namespace Modules\Core;

	use Modules\Core\Abstracts\BaseSettingsClass;

	class SettingClass extends BaseSettingsClass
	{
		const UPLOAD_DRIVER=['uploads','s3'];
		const BROADCAST_DRIVER=["null","log","pusher"];
		public static function getSettingPages()
		{
			return [
                'advance'=>[
                    'id'   => 'advance',
                    'title' => __("Advance Settings"),
                    'position'=>80,
					'view'      => "Core::admin.settings.groups.advance",
					"keys"      => [
                        'map_provider',
                        'map_gmap_key',
                        'google_client_secret',
                        'google_client_id',
                        'google_enable',
                        'facebook_client_secret',
                        'facebook_client_id',
                        'facebook_enable',
                        'twitter_enable',
                        'twitter_client_id',
                        'twitter_client_secret',
                        'recaptcha_enable',
                        'recaptcha_api_key',
                        'recaptcha_api_secret',
                        'head_scripts',
                        'body_scripts',
                        'footer_scripts',
                        'size_unit',

                        'cookie_agreement_enable',
                        'cookie_agreement_button_text',
                        'cookie_agreement_content',

                        'broadcast_driver',
                        'pusher_api_key',
                        'pusher_api_secret',
                        'pusher_app_id',
                        'pusher_cluster',
					],
                    'filter_demo_mode'=>[
                        'head_scripts',
                        'body_scripts',
                        'footer_scripts',
                        'cookie_agreement_content',
                        'cookie_agreement_button_text',
                    ]
                ],
                'style'=>[
                    'id'   => 'style',
                    'title' => __("Style Settings"),
                    'position'=>70,
                    'keys'=>[
                        'enable_preloader',
                        'style_main_color',
                        'style_custom_css',
                        'style_typo',
                    ],
                    'filter_demo_mode'=>[
                        'style_custom_css',
                        'style_typo',
                    ]
                ],
			];
		}
	}
