<?php
use \Illuminate\Support\Facades\Route;

Route::group(['prefix'=>env('GIG_ROUTE_PREFIX','gig')],function(){
    Route::get('/','GigController@index')->name('gig.search'); // Search
    Route::get('/{slug}','GigController@detail')->name('gig.detail');// Detail
});

Route::group(['prefix'=>'user/'.env('GIG_ROUTE_PREFIX','gig'),'middleware' => ['auth','verified']],function(){
    Route::get('/','VendorGigController@indexGig')->name('gig.vendor.index');
    Route::get('/create','VendorGigController@createGig')->name('gig.vendor.create');
    Route::get('/edit/{id}','VendorGigController@editGig')->name('gig.vendor.edit');
    Route::get('/del/{id}','VendorGigController@deleteGig')->name('gig.vendor.delete');
    Route::post('/store/{id}','VendorGigController@store')->name('gig.vendor.store');
    Route::get('bulkEdit/{id}','VendorGigController@bulkEditGig')->name("gig.vendor.bulk_edit");
    Route::get('/booking-report/bulkEdit/{id}','VendorGigController@bookingReportBulkEdit')->name("gig.vendor.booking_report.bulk_edit");
    Route::get('/recovery','VendorGigController@recovery')->name('gig.vendor.recovery');
    Route::get('/restore/{id}','VendorGigController@restore')->name('gig.vendor.restore');
});

Route::get('gig-cat/{slug}','GigController@category')->name('gig.category');


Route::post('/gig/buy/{id}','GigController@buy')->name('gig.buy')->middleware('auth');


Route::group(['prefix'=>'seller', 'middleware' => ['auth','verified']],function(){
    Route::get('/dashboard','SellerController@dashboard')->name("seller.dashboard")->middleware('auth');
    Route::get('/orders','SellerController@orders')->name("seller.orders");
    Route::get('/order/{id}','SellerController@orderActivity')->name("seller.order");
    Route::get('/order/{id}/activity','SellerController@orderActivity')->name("seller.order.activity");
    Route::get('/order/{id}/requirements','SellerController@orderRequirements')->name("seller.order.requirements");
    Route::post('/send-message','SellerController@sendMessage')->name("seller.send_message");
});
Route::group(['prefix'=>'buyer','middleware'=>['auth','verified']],function(){
    Route::get('/orders','BuyerController@orders')->name("buyer.orders");
    Route::get('/order/{id}','BuyerController@orderActivity')->name("buyer.order");
    Route::get('/order/{id}/activity','BuyerController@orderActivity')->name("buyer.order.activity");
//    Route::get('/order/{id}/resolution','BuyerController@orderResolution')->name("buyer.order.resolution");
    Route::get('/order/{id}/delivery','BuyerController@orderDelivery')->name("buyer.order.delivery");
    Route::get('/order/{id}/requirements','BuyerController@orderRequirements')->name("buyer.order.requirements");
    Route::post('/send-message','BuyerController@sendMessage')->name("buyer.send_message");
    Route::post('/submit-requirements','BuyerController@submitRequirements')->name("buyer.submit_requirements");
    Route::get('/accept-order/{id}','BuyerController@acceptOrder')->name("buyer.accept_order");
});

Route::get('test',function(){
    return new \Modules\Gig\Emails\GigOrderEmail(\Modules\Gig\Models\GigOrder::find(1),\Modules\Gig\Models\Gig::find(1),'author');
});
