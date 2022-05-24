<?php
use Illuminate\Support\Facades\Route;

Route::get('/','SkillController@index')->name('skill.admin.index');

Route::match(['get'],'/create','SkillController@create')->name('skill.admin.create');
Route::match(['get'],'/edit/{id}','SkillController@edit')->name('skill.admin.edit');

Route::post('/store/{id}','SkillController@store')->name('skill.admin.store');

Route::get('/getForSelect2','SkillController@getForSelect2')->name('skill.admin.getForSelect2');
Route::post('/bulkEdit','SkillController@bulkEdit')->name('skill.admin.bulkEdit');
