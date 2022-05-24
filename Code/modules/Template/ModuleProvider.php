<?php
namespace Modules\Template;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getTemplateBlocks(){
        return [
            'text'=>"\\Modules\\Template\\Blocks\\Text",
            'call_to_action'=>"\\Modules\\Template\\Blocks\\CallToAction",
            'breadcrumb_section'=>"\\Modules\\Template\\Blocks\\BreadcrumbSection",
            'brands_list'=>"\\Modules\\Template\\Blocks\\BrandsList",
            'gallery'=>"\\Modules\\Template\\Blocks\\Gallery",
            'BlockCounter'=>"\\Modules\\Template\\Blocks\\BlockCounter",
            'HowItWork'=>"\\Modules\\Template\\Blocks\\HowItWork",
            'testimonial'=>"\\Modules\\Template\\Blocks\\Testimonial",
            'FaqList'=>"\\Modules\\Template\\Blocks\\FaqList",
            'hero_banner'=>"\\Modules\\Template\\Blocks\\HeroBanner",
            'about'=>"\\Modules\\Template\\Blocks\\AboutBlock",
            'app_download'=>"\\Modules\\Template\\Blocks\\AppDownload",
            'table_price'=>"\\Modules\\Template\\Blocks\\TablePrice",
            'BlockAds'=>"\\Modules\\Template\\Blocks\\AdsBlock",
            'BlockSubscribe'=>"\\Modules\\Template\\Blocks\\SubscribeBlock",
        ];
    }

    public static function getAdminMenu()
    {
        return [
            'template'=>[
                "position"=>70,
                'url'        => 'admin/module/template',
                'title'      => __('Templates'),
                'icon'       => 'icon ion-logo-html5',
                'permission' => 'template_manage',
            ]
        ];
    }
}
