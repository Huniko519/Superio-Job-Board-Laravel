<?php
namespace  Modules\Order;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{
    public static function getSettingPages()
    {
        $keys = [
            'currency_main',
            'currency_format',
            'currency_decimal',
            'currency_thousand',
            'currency_no_decimal',
            'extra_currency'
        ];
        $all = get_payment_gateways();
        $languages = \Modules\Language\Models\Language::getActive();
        if (!empty($all)) {
            foreach ($all as $k => $gateway) {
                if (!class_exists($gateway))
                    continue;
                $obj = new $gateway($k);
                $options = $obj->getOptionsConfigs();
                if (!empty($options)) {
                    foreach ($options as $option) {
                        $keys[] = 'g_' . $k . '_' . $option['id'];
                        if( !empty($option['multi_lang']) && !empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale')){
                            foreach($languages as $language){
                                if( setting_item('site_locale') == $language->locale) continue;
                                $keys[] = 'g_' . $k . '_' . $option['id'].'_'.$language->locale;
                            }
                        }
                        if ($option['type'] == 'textarea' && $option['type'] == 'editor') {
                            $htmlKeys[] = 'g_' . $k . '_' . $option['id'];
                        }
                    }
                }
            }
        }

        return [
            [
                'id'   => 'order',
                'title' => __("Order Settings"),
                'position'=>40,
                'view'=>"Order::admin.settings.order",
                "keys"=>[
                    'order_enable_recaptcha',
                    'order_term_conditions',
                    'logo_invoice_id',
                    'invoice_company_info',
                    'booking_guest_checkout',
                    'booking_why_book_with_us'
                ],
                'html_keys'=>[

                ],
                'filter_demo_mode'=>[
                    'order_term_conditions',
                    'invoice_company_info',
                ]
            ],
            [
                'id'   => 'payment',
                'title' => __("Payment Settings"),
                'position'=>60,
                'view'=>"Order::admin.settings.payment",
                "keys"=>$keys,
                'html_keys'=>[

                ]
            ],
        ];
    }
}
