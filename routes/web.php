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

Route::get('/', function () {
    return redirect('admin/auth/login');
});

// Route::group(['namespace' => 'Adminin\Admin\Http\Controllers','middleware' => ['web']], function()
// 	{
//     	Route::get('/','AuthController@adminGetLogin');
// 	});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');