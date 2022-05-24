<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>config('candidate.candidate_route_prefix')],function(){
    Route::get('/'.config('candidate.candidate_category_route_prefix').'/{slug}', 'CategoryController@index')->name('candidate.category.index');
    Route::get('/','CandidateController@index')->name('candidate.index');// Candidates Page
    Route::get('/{slug}','CandidateController@detail')->name('candidate.detail');// Detail
    Route::post('/contact/store','CandidateController@storeContact')->name("candidate.contact.store");
});

//Route::get('category/{slug}','CategoryController@index')->name('category.index');// Detail

