<?php

namespace App\Http\Controllers\Api\Privilege\Role\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Privilege\Role,App\Model\Privilege\Ability;


class RoleController extends Controller
{
  //
  public function add(Request $request)
  {
    $name = $request->get('name');
    if ( Role::where('name',$name)->count() ) {
      return $this->apiResponse(1,'角色名称不能重复');
    }
    $obj = new Role;
    $obj->name = $name;
    $obj->save();
    return $this->apiResponse();
  }

  public function edit(Request $request,$id)
  {
    $name = $request->get('name');
    if ( Role::where('name',$name)->where('id','!=',$id)->count() ) {
      return $this->apiResponse(1,'角色名称不能重复');
    }
    $obj = Role::find($id);
    $obj->name = $name;
    $obj->save();
    return $this->apiResponse();
  }

  // 权限
  public function permit(Request $request,$id)
  {
    $actionGranteds = $request->get('action_granteds',[]);
    $actionDelete = [];
    foreach ($actionGranteds as $action) {
      Ability::firstOrCreate(['role_id'=>$id,'ability'=>$action,'type'=>2]);
      $actionDelete[] = $action;
    }
    Ability::whereNotIn('ability',$actionDelete)->where('role_id',$id)->where('type',2)->delete();

    // 菜单权限
    $menuGranteds = $request->get('menu_granteds',[]);
    $menuDelete = [];
    foreach ($menuGranteds as $menu) {
      Ability::firstOrCreate(['role_id'=>$id,'ability'=>$menu,'type'=>1]);
      $menuDelete[] = $menu;
    }
    Ability::whereNotIn('ability',$menuDelete)->where('role_id',$id)->where('type',1)->delete();
    return $this->apiResponse();
  }

}
