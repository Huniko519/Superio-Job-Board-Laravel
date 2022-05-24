<?php
namespace Modules\Skill;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }


    public static function getAdminMenu()
    {
        return [
            'skill'=>[
                "position"=>30,
                'url'        => route('skill.admin.index'),
                'title'      => __("Skill"),
                'icon'       => 'icon ion-md-bookmarks',
                'permission' => 'skill_manage_others'
            ]
        ];
    }
    public static function getTemplateBlocks(){
        return [

        ];
    }
}
