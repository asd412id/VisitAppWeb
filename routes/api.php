<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1'], function()
{
  Route::get('/', function()
  {
    return response()->json([
      'status'=>'error',
      'message'=>'Access Denied!',
    ],403);
  });
  Route::get('/connect', 'MobileApiController@index');
  Route::post('/visit', 'MobileApiController@startVisit');
  Route::put('/visit', 'MobileApiController@endVisit');
});
