<?php
use Illuminate\Support\Facades\Route;
Route::get('gateway_callback/checkourRazorPayGT/{c}/{r}','RazorPayCheckoutController@handleCheckout')->name('checkoutRazorPayGateway');
Route::post('gateway_callback/processRazorPayGT/{c}/{r}','RazorPayCheckoutController@handleProcess')->name('processRazorPayGateway');
