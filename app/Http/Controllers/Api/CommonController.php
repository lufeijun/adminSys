<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
  //
  public function uploadImage( Request $request )
  {
    return uploadImg( $request , public_path().'/sys_images' );
  }
}
