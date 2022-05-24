<?php
namespace Plugins\PaymentFlutterWaveCheckout;

use Modules\ModuleServiceProvider;
use Plugins\PaymentFlutterWaveCheckout\Gateway\FlutterWaveCheckoutGateway;

class ModuleProvider extends ModuleServiceProvider
{
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getPaymentGateway()
    {
        return [
            'flutter_wave_checkout_gateway' => FlutterWaveCheckoutGateway::class
        ];
    }

    public static function getPluginInfo()
    {
        return [
            'title'   => __('Gateway FlutterWave'),
            'desc'    => __('Welcome to FlutterWave!'),
            'author'  => "Booking Core",
            'version' => "1.0.0",
        ];
    }
}
