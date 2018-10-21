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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'type:ADMIN']], function () {
    Route::get('/Admin/', 'HomeController@index');
    Route::get('/admin/home','Admin\admin\HomeController@index')->name('adminHome');
    Route::resource('/admin/advertisement','Admin\admin\AdvertisementController');
    Route::get('/admin/advertisement/accept/{advId}','Admin\admin\AdvertisementController@accept');
    Route::delete('/admin/advertisers/delete/{advertiserId}','Admin\admin\AdvertiserController@delete');
    Route::get('/admin/advertisers/index','Admin\admin\AdvertiserController@index');

});

Route::group(['middleware' => ['auth', 'type:ADVERTISER']], function () {
    Route::get('/Advertiser/', 'HomeController@index');
    Route::get('/Advertiser/home','Admin\advertiser\HomeController@index')->name('advertiserHome');
    Route::resource('/Advertiser/advertises','Admin\advertiser\AdvertiseController');
});


