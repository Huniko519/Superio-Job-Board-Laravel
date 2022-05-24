<?php
namespace Modules\Core;
use Illuminate\Support\Facades\Event;
use Modules\Core\Events\CreatedServicesEvent;
use Modules\Core\Events\CreateReviewEvent;
use Modules\Core\Events\UpdatedServiceEvent;
use Modules\Core\Helpers\SitemapHelper;
use Modules\Core\Listeners\CreatedServicesListen;
use Modules\Core\Listeners\CreateReviewListen;
use Modules\Core\Listeners\UpdatedServicesListen;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        Event::listen(CreatedServicesEvent::class,CreatedServicesListen::class);
        Event::listen(UpdatedServiceEvent::class,UpdatedServicesListen::class);
        Event::listen(CreateReviewEvent::class,CreateReviewListen::class);

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(BladeServiceProvider::class);
        $this->app->singleton(SitemapHelper::class,function($app){
            return new SitemapHelper();
        });
    }


    public static function getAdminSubmenu()
    {
        return [
            [
                'id'=>'plugin',
                'parent'=>'tools',
                'title'=>__("Plugins"),
                'url'=>'admin/module/core/plugins',
                'permission'=>'setting_manage'
            ]
        ];
    }
}
