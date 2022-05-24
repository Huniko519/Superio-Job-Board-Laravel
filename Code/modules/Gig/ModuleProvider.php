<?php
namespace Modules\Gig;
use Modules\Core\Helpers\SitemapHelper;
use Modules\Gig\Models\Gig;
use Modules\Gig\Models\GigCategory;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(SitemapHelper $sitemapHelper){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        if(is_installed() and Gig::isEnable()){

            $sitemapHelper->add("gig",[app()->make(Gig::class),'getForSitemap']);
            $sitemapHelper->add("gig-category",[app()->make(GigCategory::class),'getForSitemap']);
        }
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        if(!Gig::isEnable()) return [];
        return [
            'gig'=>[
                "position"=>40,
                'url'        => route('gig.admin.index'),
                'title'      => __('Gigs'),
                'icon'       => 'ion-ios-calendar',
                'permission' => 'gig_manage',
                'children'   => [
                    'add'=>[
                        'url'        => route('gig.admin.index'),
                        'title'      => __('All Gigs'),
                        'permission' => 'gig_manage',
                    ],
                    'create'=>[
                        'url'        => route('gig.admin.create'),
                        'title'      => __('Add new Gig'),
                        'permission' => 'gig_manage',
                    ],
                    'cat'=>[
                        'url'        => route('gig.admin.category.index'),
                        'title'      => __('Category'),
                        'permission' => 'gig_manage_others',
                    ],
                    'cat_type'=>[
                        'url'        => route('gig.admin.category_type.index'),
                        'title'      => __('Category Types'),
                        'permission' => 'gig_manage_others',
                    ],
                    'attribute'=>[
                        'url'        => route('gig.admin.attribute.index'),
                        'title'      => __('Attributes'),
                        'permission' => 'gig_manage_others',
                    ],
                    'recovery'=>[
                        'url'        => route('gig.admin.recovery'),
                        'title'      => __('Recovery'),
                        'permission' => 'gig_manage_others',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Gig::isEnable()) return [];
        return [
            'gig'=>Gig::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        if(!Gig::isEnable()) return [];
        return [
            'gig'=>[
                'class' => Gig::class,
                'name'  => __("Gig"),
                'items' => Gig::searchForMenu(),
                'position'=>51
            ]
        ];
    }

    public static function getUserMenu()
    {
        if(!Gig::isEnable()) return [];
        return [
            'gig' => [
                'url'   => route('gig.vendor.index'),
                'title'      => __("Manage Gig"),
                'icon'       => Gig::getServiceIconFeatured(),
                'position'   => 34,
                'permission' => 'gig_manage',
                'children' => [
                    [
                        'url'   => route('gig.vendor.index'),
                        'title'  => __("All Gigs"),
                    ],
                    [
                        'url'   => route('gig.vendor.create'),
                        'title'      => __("Add Gig"),
                        'permission' => 'gig_manage',
                    ],
                    'availability'=>[
                        'url'        => route('gig.vendor.availability.index'),
                        'title'      => __('Availability'),
                        'permission' => 'gig_manage',
                    ],
                    [
                        'url'   => route('gig.vendor.recovery'),
                        'title'      => __("Recovery"),
                        'permission' => 'gig_manage',
                    ],
                ]
            ],
        ];
    }

}
