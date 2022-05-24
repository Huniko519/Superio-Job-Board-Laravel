<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('job.job_route_prefix')],function(){
    Route::get('/','JobController@index')->name('job.search');
    Route::get('/{slug}','JobController@detail');

    Route::post('/apply-job', 'JobController@applyJob')->name('job.apply-job');
    Route::get('/'.config('job.job_category_route_prefix').'/{slug}', 'JobController@categoryIndex')->name('job.category.index');
    Route::get('/'.config('job.job_location_route_prefix').'/{slug}', 'JobController@locationIndex')->name('job.location.index');
    Route::get('/{cat_slug}/{location_slug}', 'JobController@categoryLocationIndex')->name('job.category.location.index');
});
