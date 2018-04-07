<?php

namespace App\Http\Controllers\Privilege\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Model\Privilege\Role;

class MemberController extends Controller
{
  //
  public function list(Request $request)
  {
    $name  = $request->get('name','');
    $phone = $request->get('phone','');
    $email = $request->get('email','');
    $role  = $request->get('role','');
    $enable= $request->get('enable','-1');
    $roles = Role::get();

    // 管理员
    $users = User::where('id','!=','0');

    if ( $name ) {
      $users = $users->where('name','like','%'.$name.'%');
    }
    if ( $phone ) {
      $users = $users->where('phone','like','%'.$phone.'%');
    }
    if ( $email ) {
      $users = $users->where('email','like','%'.$email.'%');
    }
    if ( $role ) {
      $users = $users->where('role','like','%,'.$role.',%');
    }
    if ( $enable != '-1' ) {
      $users = $users->where('enable',$enable);
    }

    $users = $users->orderBy('id','desc')->paginate(20);
    return view('privilege/member/list')
            ->withName($name)
            ->withPhone($phone)
            ->withEmail($email)
            ->withRole($role)
            ->withEnable($enable)
            ->withUsers($users)
            ->withDefaultPassword('123456789')
            ->withDefaultEmail('@ooxx.com')
            ->withRoles($roles);
  }
}
