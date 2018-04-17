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

Route::get('/', function () {return view('welcome');})->name('home');
Route::get('home', function(){return redirect()->to(route('home'));});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

//Route::get('/home', 'HomeController@index')->name('home');

//Rol
Route::get('roles','RolController@index')->name('roles')->middleware('permission:list.role');
Route::group(['prefix' => 'rol'],function(){
    Route::get('create','RolController@create')->name('roles.create')->middleware('permission:create.role');
    Route::post('','RolController@store')->name('roles.store')->middleware('permission:create.role');
    Route::get('detail/{rol_slug}','RolController@show')->name('role')->middleware('permission:see.role');
    Route::get('edit/{rol_slug}','RolController@edit')->name('roles.edit')->middleware('permission:edit.role');
    Route::put('{rol_id}','RolController@update')->name('roles.update')->middleware('permission:edit.role');
    Route::put('permission/{rol_id}','RolController@updatePermission')->name('roles.update.permission')->middleware('permission:edit.role');
    Route::delete('{rol_id}','RolController@destroy')->name('roles.destroy')->middleware('permission:delete.role');
});

//User
Route::get('users','UserController@index')->name('users')->middleware('permission:list.user');
Route::group(['prefix'=>'user'],function(){
    Route::get('create','UserController@create')->name('users.create')->middleware('permission:create.user');
    Route::post('','UserController@store')->name('users.store')->middleware('permission:create.user');
    Route::get('detail/{user_name}','UserController@show')->name('user')->middleware('permission:see.user');
    Route::get('edit/{user_name}','UserController@edit')->name('users.edit')->middleware('permission:edit.user');
    Route::put('{user_id}','UserController@update')->name('users.update')->middleware('permission:edit.user');
    Route::delete('{user_id}','UserController@destroy')->name('users.destroy')->middleware('permission:delete.user');
});

//Area
Route::get('/areas','AreaController@index')->name('areas')->middleware('permission:list.area');
Route::group(['prefix' => 'area'],function(){
    Route::get('create','AreaController@create')->name('areas.create')->middleware('permission:create.area');
    Route::post('','AreaController@store')->name('areas.store')->middleware('permission:create.area');
    Route::get('detail/{area_name}','AreaController@show')->name('area')->middleware('permission:see.area');
    Route::get('edit/{area_name}','AreaController@edit')->name('areas.edit')->middleware('permission:edit.area');
    Route::put('{area_id}','AreaController@update')->name('areas.update')->middleware('permission:edit.area');
    Route::delete('','AreaController@destroy')->name('areas.destroy')->middleware('permission:delete.area');
});

//Permisos
Route::get('/permissions','PermissionController@index')->name('permissions')->middleware('permission:list.permission');
Route::group(['prefix' => 'permission'],function(){
    //Route::get('detail','PermissionController@detail')->name('permissions.detail')->middleware('permission:detail.permission');   //No puedo crear permisos
    //Route::post('','PermissionController@store')->name('permissions.store')->middleware('permission:detail.permission');          //No puedo crear permisos
    Route::get('detail/{permission_slug}','PermissionController@show')->name('permission')->middleware('permission:see.permission');
    Route::get('edit/{permission_slug}','PermissionController@edit')->name('permissions.edit')->middleware('permission:edit.permission');
    Route::put('{permission_id}','PermissionController@update')->name('permissions.update')->middleware('permission:edit.permission');
    //Route::delete('{permission_id}','PermissionController@destroy')->name('permissions.destroy')->middleware('permission:delete.permission');
});

//Solicitudes
Route::get('solicitudes/{estado}','SolicitudeController@index')->name('solicitudes')->middleware('permission:list.solicitude');
Route::group(['prefix' => 'solicitud'],function(){
    Route::get('create/{solicitude_id?}/','SolicitudeController@create')->name('solicitude.create')->middleware('permission:create.solicitude');
    Route::get('create2/{tipo_sol}/{action}/{solicitude_id?}','SolicitudeController@create2')->name('solicitude.create2')->middleware('permission:create.solicitude');
    Route::post('paso1','SolicitudeController@store')->name('solicitude.store')->middleware('permission:create.solicitude');
    Route::post('paso2','SolicitudeController@store2')->name('solicitude.store2')->middleware('permission:create.solicitude');
    Route::get('see/{estado}/{solicitude_id}','SolicitudeController@show')->name('solicitude')->middleware('permission:see.solicitude');
    Route::get('edit/{solDetail_id}','SolicitudeController@edit')->name('solicitude.edit')->middleware('permission:edit.solicitude');
    Route::put('{solDetail_id}','SolicitudeController@update')->name('solicitude.update')->middleware('permission:edit.solicitude');
    Route::delete('detail/{solDetail_id}','SolicitudeController@destroyDetail')->name('solicitude.destroy.detail')->middleware('permission:delete.solicitude');
    Route::delete('batch/{solicitude_id}','SolicitudeController@destroyBatch')->name('solicitude.destroy.batch')->middleware('permission:delete.solicitude');
    Route::put('generate/{solicitude_id}','ApprobationController@store')->name('solicitude.generate')->middleware('permission:edit.solicitude');
});

//Aprobaciones
Route::get('approbations','ApprobationController@index')->name('approbations')->middleware('permission:list.approbation');
Route::group(['prefix' => 'approbation'],function(){
    //Route::get('create/{approbation_id?}/','ApprobationController@create')->name('approbation.create')->middleware('permission:create.approbation');
    //Route::post('store','ApprobationController@store')->name('approbation.store')->middleware('permission:create.approbation');
    Route::get('see/{approbation_id}','ApprobationController@show')->name('approbation')->middleware('permission:see.approbation');
    Route::get('edit/{approbation_id}','ApprobationController@edit')->name('approbation.edit')->middleware('permission:edit.approbation');
    Route::put('action/{approbation_id}','ApprobationController@update')->name('approbation.update')->middleware('permission:edit.approbation');
    //Route::delete('detail/{approbation_id}','ApprobationController@destroy')->name('approbation.destroy')->middleware('permission:delete.approbation');
});

//Menus
Route::get('menus','MenuController@index')->name('menus')->middleware('permission:list.menu');
Route::group(['prefix' => 'menu'],function(){
    Route::get('see/{menu_id}','MenuController@show')->name('menu')->middleware('permission:see.menu');
    Route::get('edit/{menu_id}','MenuController@edit')->name('menu.edit')->middleware('permission:edit.menu');
});

//Tipos de Solicitudes
Route::get('solicitudeTypes','SolicitudeTypeController@index')->name('solicitudeTypes')->middleware('permission:list.solicitudetype');
Route::group(['prefix' => 'solicitudeType'],function(){
    Route::get('create/{sol_type_id}/','SolicitudeTypeController@create')->name('solicitudeType.create')->middleware('permission:create.solicitudetype');
    Route::get('see/{sol_type_id}','SolicitudeTypeController@show')->name('solicitudeType')->middleware('permission:see.solicitudetype');
    Route::get('edit/{sol_type_id}','SolicitudeTypeController@edit')->name('solicitudeType.edit')->middleware('permission:edit.solicitudetype');
    Route::put('{sol_type_id}','SolicitudeTypeController@update')->name('solicitudeType.update')->middleware('permission:edit.solicitudetype');
});

Route::get('solicitudeActions',function(){return 0;})->name('solicitudeActions')->middleware('permission:list.solicitudeaction');
Route::get('approbationFormats',function(){return 0;})->name('approbationFormats')->middleware('permission:list.approbationformat');

