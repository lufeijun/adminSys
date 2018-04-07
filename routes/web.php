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
  return redirect('admin');
});

Auth::routes();

// 所有后台系统的前缀为admin
Route::group(['prefix' => 'admin','middleware'=>'auth'], function () {
  // 首页
  Route::get('/', function () {
    return view('home');
  });


  // 权限
  Route::group(['prefix'=>'privilege','namespace'=>'Privilege'],function(){
    Route::group(['prefix'=>'member','namespace' => 'Member'], function () {
      Route::get('list', 'MemberController@list');
    });
    Route::group(['prefix'=>'role','namespace' => 'Role'], function () {
      Route::get('list', 'RoleController@list');
      Route::get('permit/show/{id}', 'RoleController@permit');
    });
  });

});