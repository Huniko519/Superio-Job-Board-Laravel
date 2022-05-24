<?php
namespace Modules\Candidate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){

        $this->publishes([
            __DIR__.'/Config/config.php' => config_path('candidate.php'),
        ]);

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/config.php', 'candidate'
        );

        $this->app->register(RouteServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        $candidate_menus = [
            'candidate'=>[
                "position"=>26,
                'url'        => route('candidate.admin.index'),
                'title'      => __("Candidate"),
                'icon'       => 'ion-md-bookmarks',
                'permission' => 'candidate_manage_others',
                'children'   => [
                    'candidates_view'=>[
                        'url'        => route('candidate.admin.index'),
                        'title'      => __("All Candidates"),
                        'permission' => 'candidate_manage',
                    ],
                    'candidates_create'=>[
                        'url'        => route('user.admin.create', ['candidate_create' => 1]),
                        'title'      => __("Add Candidate"),
                        'permission' => 'candidate_manage',
                    ],
                    'category'=>[
                        "position"=> 29,
                        'url'        => route('candidate.admin.category.index'),
                        'title'      => __("Category"),
                        'permission' => 'category_manage_others'
                    ]
                ]
            ],

        ];
        if(Auth::check()){
            if(Auth::user()->hasPermission('candidate_manage') && !Auth::user()->hasPermission('candidate_manage_others')){
                $candidate_menus['candidate_my_applied'] = [
                    "position"=> 27,
                    'url'        => route('candidate.admin.myApplied'),
                    'title'      => __("My Applied"),
                    'icon'       => 'ion-md-bookmarks',
                    'permission' => 'candidate_manage'
                ];
            }
        }
        return $candidate_menus;
    }

    public static function getTemplateBlocks(){
        return [
            'list_candidates'=>"\\Modules\\Candidate\\Blocks\\ListCandidates",
        ];
    }
}
