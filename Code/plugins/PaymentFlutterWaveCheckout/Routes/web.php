<?php
use Illuminate\Support\Facades\Route;

Route::get('gateway_callback/checkoutFlutterWaveGateway/{payment_id}','FlutterWaveCheckoutController@handleCheckout')->name('checkoutFlutterWaveGateway');
Route::get('gateway_callback/checkoutNormalFlutterWaveGateway/{payment_id}','FlutterWaveCheckoutController@handleCheckoutNormal')->name('checkoutNormalFlutterWaveGateway');



