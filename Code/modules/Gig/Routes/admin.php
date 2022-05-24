<?php
use \Illuminate\Support\Facades\Route;
Route::get('/','GigController@index')->name('gig.admin.index');
Route::get('/create','GigController@create')->name('gig.admin.create');
Route::get('/edit/{id}','GigController@edit')->name('gig.admin.edit');
Route::post('/store/{id}','GigController@store')->name('gig.admin.store');
Route::post('/bulkEdit','GigController@bulkEdit')->name('gig.admin.bulkEdit');
Route::get('/recovery','GigController@recovery')->name('gig.admin.recovery');
Route::get('/getForSelect2','GigController@getForSelect2')->name('gig.admin.getForSelect2');

Route::group(['prefix'=>'attribute'],function (){
    Route::get('/','AttributeController@index')->name('gig.admin.attribute.index');
    Route::get('edit/{id}','AttributeController@edit')->name('gig.admin.attribute.edit');
    Route::post('store/{id}','AttributeController@store')->name('gig.admin.attribute.store');
    Route::post('/editAttrBulk','AttributeController@editAttrBulk')->name('gig.admin.attribute.editAttrBulk');

    Route::get('terms/{id}','AttributeController@terms')->name('gig.admin.attribute.term.index');
    Route::get('term_edit/{id}','AttributeController@term_edit')->name('gig.admin.attribute.term.edit');
    Route::post('term_store','AttributeController@term_store')->name('gig.admin.attribute.term.store');
    Route::post('/editTermBulk','AttributeController@editTermBulk')->name('gig.admin.attribute.term.editTermBulk');

    Route::get('getForSelect2','AttributeController@getForSelect2')->name('gig.admin.attribute.term.getForSelect2');
});

Route::group(['prefix'=>'category'],function (){
    Route::get('/','CategoryController@index')->name('gig.admin.category.index');
    Route::get('/edit/{id}','CategoryController@edit')->name('gig.admin.category.edit');
    Route::post('/store/{id}','CategoryController@store')->name('gig.admin.category.store');
    Route::post('/bulkEdit','CategoryController@bulkEdit')->name('gig.admin.category.bulkEdit');
    Route::get('/getForSelect2','CategoryController@getForSelect2')->name('gig.admin.category.getForSelect2');
});
Route::group(['prefix'=>'category_type'],function (){
    Route::get('/','CategoryTypeController@index')->name('gig.admin.category_type.index');
    Route::get('/edit/{id}','CategoryTypeController@edit')->name('gig.admin.category_type.edit');
    Route::post('/store/{id}','CategoryTypeController@store')->name('gig.admin.category_type.store');
    Route::post('/bulkEdit','CategoryTypeController@bulkEdit')->name('gig.admin.category_type.bulkEdit');
    Route::get('/getForSelect2','CategoryTypeController@getForSelect2')->name('gig.admin.category_type.getForSelect2');
});

