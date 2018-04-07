<?php

namespace App\Http\Controllers\Api\Privilege\Member\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  //
  public function logout()
  {
    // Auth::logout();
    $this->middleware('guest')->except('logout');
    return $this->apiResponse();
  }
}
