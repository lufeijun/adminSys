<?php
/**
 * 菜单栏相关
 */

// 获取上层大模块
function getFirstMenuName()
{
  $module = '';
  $path = explode('/',Request::path());
  if ( count( $path ) > 2 ) {
    $menuFirst = config('menu.first');
    $firstMenuKey = $path[1];
    if ( isset( $menuFirst[$firstMenuKey] ) ) {
      $module = $menuFirst[$firstMenuKey];
    }
  }
  return $module;
}

/**
 * 检测菜单权限，
 * 横向菜单为一级权限
 * 左侧分别为二级、三级权限
 * @param menu  对应菜单权限字符串
 * @param level 级别，值为 first、second、three
 * @param enableJump 是否跳转到无权限提示页面
 */
function checkMenuGranted($menu,$level,$enableJump = false)
{
  $menuArr = getLoginedMessage('menu_'.$level.'_granted',[]);
  $enable = isset( $menuArr[$menu] );
  if ($enableJump && ! $enable) {
    throw new \App\Exceptions\PrivilegeException("无操作权限");
  }
  return $enable;
}

/**
 * 检测功能权限
 *
 * @param enableJump 是否跳转到无权限提示页面
 */
function checkActionGranted($action,$enableJump = false)
{
  $enable = in_array($action, getLoginedMessage('action_granted',[]));
  if ($enableJump && ! $enable) {
    throw new \App\Exceptions\PrivilegeException("无操作权限");
  }
  return $enable;
}


/**
 * 路由问题
 */

// 依据角色获取首页页面，依据角色定制首页
function getHomeUrlByRole()
{
  $url = url('admin');


  return $url;
}

/**
 * 判断是否为当前URL，用来控制是否选中左侧材料栏
 */
function isCurrentUrl($url,$containUrl)
{
  foreach ($containUrl as $contain) {
    if ( strpos($url,$contain) !== false ) {
      return true;
    }
  }
  return false;
}

// 依据各个角色获取左菜单栏默认展开项
function getMenuDefault()
{
  $menuName = '';
 
  return $menuName;
}


/**
 * 获取登录用户信息，主要是image和roles字段
 */
function getLoginedMessage($field , $default='')
{
  if ( session()->has('administrator') && isset(session('administrator')[$field]) ) {
    return  session('administrator')[$field];
  } else {
    return $default;
  }
}

/**
 * 上传图片的公用函数
 */
function uploadImg( $request , $toPath )
{
  if ($request->hasFile('file')) {
    $file = $request->file('file');
    $fileName = \Ramsey\Uuid\Uuid::uuid1()->toString();
    $imgName = $fileName.'.'.$file->getClientOriginalExtension();
    $file->move( $toPath , $imgName );
    $image = \Image::make( $toPath.'/'.$imgName);
    if ($image->width() > 1500) {
      $image->resize(1500, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $image->save();
    }
    // 将图片传到图片服务器，并将本机的图片重命名
    if ( $fileName ) {
      $image->save( $toPath.'/'.$fileName.'.jpg');
    }
    return $fileName;
  } else {
    return '0';
  }
}