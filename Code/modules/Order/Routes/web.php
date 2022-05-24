<?php
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'cart','middleware'=>'auth'],function(){
    Route::get('/','CartController@index')->name('cart');
    Route::post('/addToCart','CartController@addToCart')->name('cart.addToCart');
    Route::post('/remove_cart_item','CartController@removeCartItem')->name('cart.remove_cart_item');
});

Route::group(['prefix'=>'checkout','middleware'=>'auth'],function(){
    Route::get('/','CheckoutController@index')->name('checkout');
    Route::post('/process','CheckoutController@process')->name('checkout.process');
});

Route::group(['prefix'=>'order'],function(){
    Route::get('/confirm/{gateway}','OrderController@confirmPayment')->name('order.confirm');
    Route::get('/cancel/{gateway}','OrderController@cancelPayment')->name('order.cancel');
    Route::get('/{id}','OrderController@detail')->name('order.detail')->middleware('auth');
});

Route::get('user/order','OrderController@history')->name('user.order');
