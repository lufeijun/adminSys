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

// 上传图片链接
Route::post('upload/image','Api\CommonController@uploadImage');


Route::group(['namespace'=>'Api','middleware' => 'ApiAuth'],function(){

  // 管理员管理模块
  Route::group(['namespace'=>'Privilege','prefix'=>'privilege'],function(){
    // 成员管理模块
    Route::group(['namespace'=>'Member\V1','prefix'=>'member/v1'],function(){
      Route::post('add','MemberController@add');
      Route::post('change/{id}','MemberController@change');
      Route::post('password/change/{id}','MemberController@password');
      Route::post('image/change/{id}','MemberController@image');
    });

    // 角色管理模块
    Route::group(['namespace'=>'Role\V1','prefix'=>'role/v1'],function(){
      Route::post('add','RoleController@add');
      Route::post('edit/{id}','RoleController@edit');
      Route::post('permit/{id}','RoleController@permit');
    });

    
  });


});

