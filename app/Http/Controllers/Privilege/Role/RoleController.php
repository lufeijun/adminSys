<?php

namespace App\Http\Controllers\Privilege\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Privilege\Role,App\Model\Privilege\Ability;
use \Config;


class RoleController extends Controller
{
  //
  public function list(Request $request)
  {
    checkMenuGranted('权限,角色管理,角色列表','three',true);

    $roles = Role::orderBy('id','desc')->get();
    return view('privilege/role/list')
           ->withRoles($roles);
  }

  public function permit(Request $request,$id)
  {
    $role = Role::find($id);

    // 功能权限
    $actionGranted = Ability::where('role_id',$id)->where('type',2)->pluck('ability')->toArray();
    // 菜单权限
    $menuGranted   = Ability::where('role_id',$id)->where('type',1)->pluck('ability')->toArray();

    // 功能权限
    $actionTree = config('ability.actionTree');
    $roleTreeArr = [];
    foreach ($actionTree as $ability) {
      $abilityArray = explode(',', $ability);
      if (count($abilityArray) === 3) {
        $roleTreeArr[$abilityArray[0]][$abilityArray[1]][$abilityArray[2]] = [];
      }
      if (in_array($ability, $actionGranted)) {
        $roleTreeArr[$abilityArray[0]][$abilityArray[1]][$abilityArray[2]]['selected'] = 'full';
      }
    }

    // 菜单权限
    $menuTree = config('ability.menuTree');
    $menuTreeArr = [];
    foreach ($menuTree as $menu) {
      $menuArr = explode(',', $menu);
      if (count($menuArr) == 3) {
        $menuTreeArr[$menuArr[0]][$menuArr[1]][$menuArr[2]] = [];
      }
      if (in_array($menu, $menuGranted)) {
        $menuTreeArr[$menuArr[0]][$menuArr[1]][$menuArr[2]]['selected'] = 'full';
      }
    }

    return view('privilege/role/permit')
           ->withRoleTreeArr($roleTreeArr)
           ->withMenuTreeArr($menuTreeArr)
           ->withRole($role);
  }
}
