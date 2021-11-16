<?php

// use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\beforelogin;

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

/*Route::get('/', function () {
     return view('home');
});*/

Route::get('/', 'App\Http\Controllers\Front_end\HomeController@index');

Route::post('/logout-admin', '\App\Http\Controllers\Admin\LoginController@logout');    


    
// Route::get('/admin', function(){
//     return view('auth.login');
//  });
$real_path = realpath(__DIR__).DIRECTORY_SEPARATOR.'extra_route'.DIRECTORY_SEPARATOR;
Auth::routes();
Route::get('/clear', 'App\Http\Controllers\Front_end\HomeController@clearCache')->name('clearCache');
Route::get('/admin', 'App\Http\Controllers\Admin\LoginController@adminloginview')->name('admin_login_view');
Route::get('/admin/login', 'App\Http\Controllers\Admin\LoginController@adminloginview');
Route::post('/login/proccess','App\Http\Controllers\Admin\LoginController@adminloginproccess')->name('admin_login_proccess');

Route::post('/city/getcountrystate','App\Http\Controllers\Admin\CityController@selectstate')->name('admin-city-getcountrystate');
Route::post('/city/getstatecity','App\Http\Controllers\Admin\CityController@selectcity')->name('admin-city-getstatecity');
Route::post('/categories/subcategories','App\Http\Controllers\Admin\CompaniesController@GetsubCategory')->name('admin-subcategories');


Route::get('/register', 'App\Http\Controllers\Admin\LoginController@register')->name('register');
Route::group(['middleware' => ['auth']], function () {     
});


include_once($real_path .'mohit.php');
include_once($real_path .'chirag.php');