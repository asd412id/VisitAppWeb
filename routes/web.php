<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'VisitController@index')->name('visit.index');
Route::post('/', 'VisitController@check')->name('visit.check');
Route::get('/registrasi', 'VisitController@formKunjungan')->name('visit.form');
Route::post('/registrasi', 'VisitController@store')->name('visit.store');
Route::get('/status/{uuid}', 'VisitController@status')->name('visit.status');
Route::post('/guest-token', 'AjaxController@storeToken')->name('ajax.token.guest.store');

Route::group(['middleware'=>'guest'], function()
{
  Route::get('/login', 'MainController@login')->name('login');
  Route::post('/login', 'MainController@loginProcess')->name('login.process');
});

Route::group(['middleware'=>'auth','prefix'=>'admin'], function()
{
  Route::get('/', 'MainController@index')->name('home');

  Route::get('/keluar', 'MainController@logout')->name('logout');

  Route::get('/pengaturan', 'MainController@sysConf')->name('configs');
  Route::post('pengaturan', 'MainController@sysConfUpdate')->name('configs.update');

  Route::get('/pengaturan/akun', 'MainController@profile')->name('profile');
  Route::post('/pengaturan/akun', 'MainController@profileUpdate')->name('profile.update');

  Route::get('/pengaturan/hapus-img/{img}', 'MainController@deleteImg')->name('configs.delete.img');
  Route::get('/pengaturan/cetakqr', 'MainController@printQR')->name('configs.print.qr');

  Route::group(['prefix'=>'ajax'], function()
  {
    Route::get('/ruang', 'AjaxController@searchruang')->name('ajax.ruang');
    Route::post('/token', 'AjaxController@storeToken')->name('ajax.token.store');
    Route::post('/notification', 'AjaxController@storeNotification')->name('ajax.notification.store');
  });

  Route::group(['prefix'=>'pengunjung'], function()
  {
    Route::get('/', 'GuestController@index')->name('guest.index');
    Route::post('/show', 'GuestController@show')->name('guest.show');
  });

  Route::group(['prefix'=>'notifikasi'], function()
  {
    Route::get('/', 'NotificationController@index')->name('notif.index');
    Route::get('/{uuid}', 'NotificationController@show')->name('notif.show');
    Route::get('/{uuid}/hapus', 'NotificationController@destroy')->name('notif.destroy');
    Route::post('/{uuid}', 'NotificationController@action')->name('notif.action');
  });

  Route::group(['prefix'=>'ruang'], function()
  {
    Route::get('/', 'RuangController@index')->name('ruang.index');
    Route::get('/ubah/{uuid}', 'RuangController@edit')->name('ruang.edit');
    Route::post('/ubah/{uuid}', 'RuangController@update')->name('ruang.update');
  });

  Route::group(['middleware'=>'roles:admin'], function()
  {
    Route::group(['prefix'=>'ruang'], function()
    {
      Route::get('/tambah', 'RuangController@create')->name('ruang.create');
      Route::post('/tambah', 'RuangController@store')->name('ruang.store');
      Route::get('/hapus/{uuid}', 'RuangController@destroy')->name('ruang.destroy');
    });
    Route::group(['prefix'=>'pengguna'], function()
    {
      Route::get('/', 'UsersController@index')->name('users.index');
      Route::get('/tambah', 'UsersController@create')->name('users.create');
      Route::post('/tambah', 'UsersController@store')->name('users.store');
      Route::get('/ubah/{uuid}', 'UsersController@edit')->name('users.edit');
      Route::post('/ubah/{uuid}', 'UsersController@update')->name('users.update');
      Route::get('/hapus/{uuid}', 'UsersController@destroy')->name('users.destroy');
    });
  });

});
