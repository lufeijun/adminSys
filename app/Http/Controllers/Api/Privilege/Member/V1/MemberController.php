<?php

namespace App\Http\Controllers\Api\Privilege\Member\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;


class MemberController extends Controller
{
  //
  public function change(Request $request,$id)
  {
    $user = User::find($id);
    $user->phone  = $request->get('phone','');
    $user->address  = $request->get('address','');
    $user->role  = $request->get('role','');
    $password  = $request->get('password','');
    if ( $password ) {
      $user->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }
    $user->save();

    return $this->apiResponse();
  }

  public function add(Request $request)
  {
    $name = $request->get('name','');
    $email = $request->get('email','');
    $phone = $request->get('phone','');
    $address = $request->get('address','');
    $role = $request->get('role','');
    $enable = $request->get('enable','');
    $password = $request->get('password','');

    $have = User::where('email',$email)->count();

    if ( $have ) {
      return $this->apiResponse(1,'管理员邮箱不能重复');
    }

    $obj = new User;
    $obj->name = $name;
    $obj->email = $email;
    $obj->phone = $phone;
    $obj->address = $address;
    $obj->role = $role;
    $obj->enable = $enable;
    $obj->password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    $obj->save();
    return $this->apiResponse();
  }

  public function password(Request $request,$id)
  {
    $old = $request->get('old_password','');
    $new = $request->get('new_password','');

    $user = User::find($id);

    if ( $user->password != password_hash($old, PASSWORD_BCRYPT, ['cost' => 10]) ) {
      return $this->apiResponse(1,'旧密码错误');
    } else {
      $user->password = password_hash($new, PASSWORD_BCRYPT, ['cost' => 10]);
      $user->save();
      return $this->apiResponse();
    }
  }

  public function image(Request $request,$id)
  {
    $user = User::find($id);
    $user->image = $request->get('image','');
    $user->save();
    return $this->apiResponse();

  }
}
