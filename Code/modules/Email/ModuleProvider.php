<?php
namespace Modules\Email;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Modules\Email\Plugins\InlineCssPlugin;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){
        try {
            $this->app['mailer']->getSwiftMailer()->registerPlugin(new InlineCssPlugin());
        } catch (\Exception $e) {
            Log::debug('Cant register InlineCssPlugin.');
        }
    }
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

}
