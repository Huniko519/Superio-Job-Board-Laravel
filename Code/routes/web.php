<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/intro','\App\Http\Controllers\LandingpageController@index');
Route::get('/', '\App\Http\Controllers\HomeController@index')->name('home');
Route::post('/install/check-db', '\App\Http\Controllers\HomeController@checkConnectDatabase');

Route::get('/update', function (){
    return redirect('/');
});

//Cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cleared!";
})->middleware(['auth', 'dashboard']);

//Login
Auth::routes();
//Custom User Login and Register
Route::post('register','\Modules\User\Controllers\UserController@userRegister')->name('auth.register');
Route::post('login','\Modules\User\Controllers\UserController@userLogin')->name('auth.login');
Route::post('logout','\Modules\User\Controllers\UserController@logout')->name('auth.logout');
// Social Login
Route::get('social-login/{provider}', '\App\Http\Controllers\Auth\LoginController@socialLogin');
Route::get('social-callback/{provider}', '\App\Http\Controllers\Auth\LoginController@socialCallBack');

// Logs
Route::get('admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware(['auth', 'dashboard','system_log_view']);

//Icon Helper
Route::get('bc-helper/icons', '\App\Http\Controllers\BCController@index')->middleware(['auth'])->name('bc.icons');
