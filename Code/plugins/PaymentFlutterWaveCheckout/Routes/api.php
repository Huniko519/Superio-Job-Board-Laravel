<?php

    use Illuminate\Support\Facades\Route;

    Route::post('gateway_callback/confirmFlutterWaveGateway/{payment_id}','FlutterWaveCheckoutController@confirmCheckout')->name('confirmFlutterWaveGateway');

    Route::post('gateway_callback/webhookFlutterWaveGateway','FlutterWaveCheckoutController@webhookCheckout')->name('webhookFlutterWaveGateway');



