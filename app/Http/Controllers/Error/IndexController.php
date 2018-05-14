<?php

namespace App\Http\Controllers\Error;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
  // 权限错误
  public function privilege()
  {
    return view('error/privilege');
  }
}
