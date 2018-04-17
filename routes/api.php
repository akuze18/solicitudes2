<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getAction','SolicitudeController@getAction')->name('getAction');
Route::post('getApprobationStatus','SolicitudeController@getApprobationStatus')->name('getApprobationStatus');
Route::post('getAreaSname','AreaController@getAreaSname')->name('getAreaSname');
Route::post('getFormatList','SolicitudeTypeController@getFormatList')->name('getFormatList');
