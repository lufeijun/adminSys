<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>后台管理系统</title>
  <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{ asset('css/2018/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/skins/skin-blue.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/sweetalert.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/bootstrap-dialog.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/2018/common.css') }}">


@if (env('APP_ENV', 'local') == 'server')
  <script src="{{ asset('js/2018/vue2.5.13.min.js') }}"></script>
@else
  <script src="{{ asset('js/2018/vue2.5.13.js') }}"></script>
@endif


<script src="{{ asset('js/2018/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('js/2018/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/2018/adminLTE.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/2018/app.min.js') }}"></script>
<script src="{{ asset('js/2018/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/2018/bootstrap-dialog.min.js') }}"></script>
<script src="{{ asset('js/2018/dropzone.js') }}"></script>
<script src="{{ asset('js/2018/common.js') }}"></script>

<style>
.login-error-message {
  display: none;
  position: absolute;
  margin-top: 355px;
}
.login-error-message img {
  width: 20px;
  height: 20px;
}
.float-left-button {
  color: #ffffff;
  float: left;
  background-color: transparent;
  background-image: none;
  padding: 14px 25px;
  font-weight: 500;
  font-size: 15px;
  line-height: 1.42857143;
}
.float-left-button:hover {
  background-color: #367fa9;
  color: #f6f6f6;
  background: rgba(0,0,0,0.1);
}
.first-menu-active{
  background-color:  #367fa9;
}
.avatar-upload-img .dz-preview {
  width: 23%;
  height: 225px;
  margin-left: 1%;
  float: left;
  text-align: center;
  z-index: 100;
  position: relative;
  top: -320px;
  padding-top: 112px;
}
.avatar-upload-img .dz-preview .dz-image {
  height: 225px;
}
.avatar-upload-img .dz-preview .dz-image img {
  width: 100%;
  display: block;
}
.avatar-upload-img .dz-error-mark{
  margin-top: -210px;
  margin-left: 150px;
}
.content {
  min-height: 800px;
}

</style>
@php
$firstMenuName = getFirstMenuName();
$menuArr = config('menu.menu');

if ( isset( $menuArr[$firstMenuName] ) ) {
  $menuArr = $menuArr[$firstMenuName];
} else {
  $menuArr = [];
}

$routePath = Request::path();
$routeController = class_basename(explode('@', \Route::currentRouteAction())[0]);
$roles = getLoginedMessage('roles');
$menuDefault = getMenuDefault();


foreach ($menuArr as $key => $value) {
  $urls = array_column($value['threeMenu'],'current');
  foreach ($urls  as $url ) {
    foreach ($url as $containUrl) {
      if( strpos($routePath,$containUrl) !== false ){
        session(['secondActive'=>$key]);
        break;
      }
    }
  }
}
@endphp
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<script>
var isEngineES5Compliant = 'create' in Object && 'isArray' in Array && 'x'[0] === 'x';
if (!isEngineES5Compliant) {
  window.location.href = "{{ url('bad-browser') }}";
}
</script>


<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{ getHomeUrlByRole() }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img style="width: 40px;" src="{{ asset('img/0.jpg') }}" alt="logo"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img style="width: 60px;" src="{{ asset('img/0.jpg') }}" alt="logo">&nbsp;&nbsp;信息管理系统</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      @foreach (getLoginedMessage('menu_first_granted',[]) as $firstMenu => $firstMenuUrl )
        <a href="{{ url($firstMenuUrl) }}" class="float-left-button
        @if ( $firstMenuName == $firstMenu )
          first-menu-active  
        @endif
        ">
          {{ $firstMenu }}
        </a>
      @endforeach
      
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            
          </li>
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ Auth::user()->image ? asset('sys_images/'.Auth::user()->image.'.jpg') : asset('img/0.jpg') }}" class="user-image" alt="User Image" title="查看、修改个人信息" style="width:25px;height:25px;object-fit:cover;">
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Body -->
              <li class="user-body personal-setting" onclick="showPersonalInformation();">
                <div class="col-xs-12">
                  个人信息
                </div>
              </li>
              <li class="user-body personal-setting" onclick="changePersonalAvatar();">
                <div class="col-xs-12">
                  修改头像
                </div>
              </li>
              <li class="user-body personal-setting" onclick="changePersonalPassword();">
                <div class="col-xs-12">
                  修改密码
                </div>
              </li>
              <li class="user-body personal-setting" onclick="logout();">
                <div class="col-xs-12">
                  退出登录
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Auth::user()->image ? asset('sys_images/'.Auth::user()->image.'.jpg') : asset('img/0.jpg') }}" class="img-circle" alt="User Image" style="width:50px;height:45px;object-fit:cover;">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i>公司口号</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        @foreach ($menuArr as $title => $menu)
          @if ( isset($menu['check']) && checkMenuGranted($menu['check'],'second') )
            <li class="treeview
            @if ( session('secondActive') == $title )
              active
            @endif
            ">
              <a href="#">
                <img src="{{ asset('img/menu/'.$menu['image']) }}" class="menu-image">
                <span>{{ $title }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                @foreach ($menu['threeMenu'] as $threeMenu)
                  @if ( checkMenuGranted( $threeMenu['check'],'three' ) )
                    <li>
                      <a href="{{ url($threeMenu['url']) }}"
                      @if (  isCurrentUrl($routePath,$threeMenu['current']) )
                        class="active"
                      @endif
                      >
                        {{ $threeMenu['name'] }}
                      </a>
                    </li>
                  @endif
                @endforeach
              </ul>
            </li>
          @endif
        @endforeach

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #f8f8f8;">
    <!-- Content Header (Page header) -->
   {{--  <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section> --}}

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  
  {{-- 退出 --}}
  <div style="display: none;">
    <a id="logout-a" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </div>


  <div id="show-personal-information">
    <div class="row" style="padding: 5px 60px;">
      <div class="col-xs-6 strong-bloder">姓名</div>
      <div class="col-xs-6 strong-bloder">手机号</div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-6">{{ Auth::user()->name }}</div>
      <div class="col-xs-6"><input type="number" class="form-control logined-phone-number" placeholder="请填写手机号码" value="{{ Auth::user()->phone }}"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12 strong-bloder">住址</div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12"><input type="text" class="form-control logined-address" placeholder="请填写住址" value="{{ Auth::user()->address }}"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-6 strong-bloder">邮箱／登录名</div>
      <div class="col-xs-6 strong-bloder">角色</div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-6 logined-email">{{ Auth::user()->email }}</div>
      <div class="col-xs-6">{{ implode('，',getLoginedMessage('roles',[])) }}</div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-6 login-error-message">
        <img src="{{ asset('/img/2018/warn.png') }}">
        <span style="color: #FF0000; margin-left: 10px;"></span>
      </div>
    </div>
  </div>

  <div id="change-personal-password">
    <div class="row" style="padding: 5px 60px;">
      <div class="col-xs-12">原密码</div>
      <div class="col-xs-12"><input type="password" class="form-control old-password" placeholder="请填写原密码" style="width:100%"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12">新密码</div>
      <div class="col-xs-12"><input type="password" class="form-control new-password" placeholder="请填写新密码" style="width:100%"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12">重复新密码</div>
      <div class="col-xs-12"><input type="password" class="form-control repeat-password" placeholder="请确认新密码" style="width:100%"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="login-error-message col-xs-6" style="margin-top: 248px;">
        <img src="{{ asset('/img/2018/warn.png') }}">
        <span style="color: #FF0000; margin-left: 10px;"></span>
      </div>
    </div>
  </div>

  <div id="change-personal-avatar" style="display: none;">
    <div class="row" style="padding: 5px 60px;">
    <div class="col-xs-12 avatar-upload-img change-avatar" id="user-image-upload" 
         style="padding: 0;   height: 300px;
           border: 5px dotted #efefef;
           cursor: pointer;">
    <h1 style="font-size: 80px;
        color: #efefef;
        text-align: center;
        z-index: 1;
        margin-top: 68px;">
      添加图片
      <div style="font-size: 50px;">支持拖拽到此区域上传</div>
    </h1>
    <div class="login-error-message col-xs-6 avatar-error" style="margin-top: 130px;">
      <img src="{{ asset('/img/2018/warn.png') }}">
      <span style="color: #FF0000; margin-left: 10px;"></span>
    </div>
  </div>
    <div class="clear"></div>   
    <script>
      BROSWER_NOT_SUPPORT = false;
      var reCountUploadHeight = function() {
        $(".avatar-upload-img").each(function(index, el) {
          var height = (Math.ceil( ($(this).find('.dz-preview').length + 1 ) / 4)) * 230 + 60;
          if (height > 300) {
            $(this).css({height: height + 'px'});
          } else {
            $(this).css({height: '300px'});
          }
        });
      };
      
      reCountUploadHeight();
      
      $("#user-image-upload").each(function() {
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(this, {
          url: "/api/upload/image",
          fallback: function() {
            BROSWER_NOT_SUPPORT = true;
            alert('你的浏览器不支持拖动上传图片，请使用谷歌 Chrome 浏览器！');
          },
          acceptedFiles: ".jpg,.png,.git,.jpeg",
        });
        var _this = $(this);
        myDropzone.on('drop', function(){
        });

        myDropzone.on("success", function(file) {
          var fileName = file.xhr.response;
          $(file.previewElement).attr('data-pic-name', fileName);
          $(file.previewElement).find('.dz-size').remove();
          $(file.previewElement).find('.dz-filename').remove();
          $(file.previewElement).find('.dz-success-mark').remove();
          $(file.previewElement).find('.dz-error-mark').click(function() {
            $(this).parents('.dz-preview').remove();
            reCountUploadHeight();
          });
          $(".dz-image").click(function(event) {
            /* Act on the event */
            var src = $(this).parents('.dz-preview').attr('data-pic-name');
          });
          reCountUploadHeight();
        });
      
      });
      
      $('.dz-preview .dz-error-mark').click(function() {
        $(this).parents('.dz-preview').remove();
        reCountUploadHeight();
      });
      
      $('.avatar-upload-img > h1').click(function(event) {
        $(this).parents('.avatar-upload-img').click();
      });
      $(".dz-image").click(function(event) {
        /* Act on the event */
        var src = $(this).find('img').attr('src');
      });
    </script>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="login-error-message col-xs-6" style="margin-top: 248px;">
        <img src="{{ asset('/img/2018/warn.png') }}">
        <span style="color: #FF0000; margin-left: 10px;"></span>
      </div>
    </div>
  </div>

  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs" style="color: #00659e; margin-right: 15px;">
      公司口号
    </div>
    <!-- Default to the left -->
    <strong>©{{ date('Y') }} ooxx
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript::;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  <div id="update-remind">
    更新成功
  </div>
</div>

<script>
var SHOW_PERSONAL_INFORMATION  = $('#show-personal-information').html();
$('#show-personal-information').remove();
var showPersonalInformation = function(){
  var dialog =  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_PRIMARY,
    title: '个人信息',
    message: SHOW_PERSONAL_INFORMATION,
    size : BootstrapDialog.SIZE_WIDE,
    nl2br: false,
    cssClass: 'plans-dialog',
    onshown: function(dialogRef){},
    buttons: [
      {
        label: '取消',
        action: function(dialogItself){
            dialogItself.close();
        }
      },
      {
        label: '保存',
        cssClass: 'btn-primary',
        action: function(dialogRef) {
          var HAS_ERROR = false;
          var phone_number = $(".logined-phone-number").val();
          var address = $(".logined-address").val();

          if ( phone_number.length !== 11 ) {
            $('.login-error-message').show().find('span').text('手机号必须为11位数字');
            HAS_ERROR = true;
          } else if ( address === '' ) {
            $('.login-error-message').show().find('span').text('地址信息不能为空');
            HAS_ERROR = true;
          }

          if (!HAS_ERROR) {
            dialogRef.enableButtons(false);
            var data = {
              phone : phone_number,
              address : address,
              role : '{{ Auth::user()->role }}',
              _token: '{{ csrf_token() }}'
            };
            $.ajax({
              url : '{{ url('/api/privilege/member/v1/change/'.Auth::user()->id) }}',
              method: 'post',
              dataType: 'json',
              data: data,
              success: function(data) {
                if ( data.status != 0 ) {
                  $('.login-error-message').text( data.message ).show();
                } else {
                  swal("修改成功", "1 秒后自动刷新", "success");
                  window.setTimeout(function(){
                      location.reload();
                    },1000);
                }
              },
              error: function() {
                alert('页面出错，请刷新');
              }
            });
          }
        }
      }
    ]
  });
}  

var CHANGE_PERSONAL_AVATAR = $('#change-personal-avatar').html();
$('#change-personal-avatar').remove();
var changePersonalAvatar  = function(){
  var dialog =  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_PRIMARY,
    title: '修改头像',
    message: CHANGE_PERSONAL_AVATAR,
    size : BootstrapDialog.SIZE_WIDE,
    nl2br: false,
    cssClass: 'plans-dialog',
    onshown: function(dialogRef){},
    buttons: [
      {
        label: '取消',
        action: function(dialogItself){
            dialogItself.close();
        }
      },
      {
        label: '确认修改',
        cssClass: 'btn-primary',
        action: function(dialogRef) {
        var HAS_ERROR = false;
          
        var image = [];
        $('.change-avatar').find('.dz-preview').each(function() {
          image.push($(this).attr('data-pic-name'));
        });
        image = image.shift();
        if(image == undefined){
          $('.avatar-error').show().find('span').text('请上传头像');
          HAS_ERROR = true;
        }else{
          image = JSON.stringify(image);
          image = image.slice(1,-1);           
        }
             
        if (!HAS_ERROR) {
          dialogRef.enableButtons(false);
          var data = {
            image: image,
            _token: '{{ csrf_token() }}'
          };
          $.ajax({
            url : '{{ url('/api/privilege/member/v1/image/change/'.Auth::user()->id) }}',
            method: 'post',
            dataType: 'json',
            data: data,
            success: function(data) {
              if ( data.status != 0 ) {
                $('.login-error-message').text( data.message ).show();
              } else {
                swal("修改成功", "1 秒后自动跳转", "success");
                dialogRef.close();
                window.setTimeout(function(){
                  location.reload();
                },1000);
              }
            },
            error: function() {
              alert('页面出错，请刷新');
            }
          });
        }
      }
    }
    ]
  });
}

var CHANGE_PERSONAL_PASSWORD  = $('#change-personal-password').html();
$('#change-personal-password').remove();
var changePersonalPassword = function(){
  var dialog =  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_PRIMARY,
    title: '修改密码',
    message: CHANGE_PERSONAL_PASSWORD,
    size : BootstrapDialog.SIZE_WIDE,
    nl2br: false,
    cssClass: 'plans-dialog',
    onshown: function(dialogRef){},
    buttons: [
      {
        label: '取消',
        action: function(dialogItself){
            dialogItself.close();
        }
      },
      {
        label: '确认修改',
        cssClass: 'btn-primary',
        action: function(dialogRef) {
          var HAS_ERROR = false;
          var old_password = $(".old-password").val();
          var new_password = $(".new-password").val();
          var repeat_password = $(".repeat-password").val();

          if ( old_password === '' ) {
            $('.login-error-message').show().find('span').text('请输入旧密码').show();
            HAS_ERROR = true;
          } else if ( new_password === '' ) {
            $('.login-error-message').show().find('span').text('请输入新密码').show();
            HAS_ERROR = true;
          } else if ( new_password !== repeat_password ) {
            $('.login-error-message').show().find('span').text('两次输入的密码不一致').show();
            HAS_ERROR = true;
          }

          if (!HAS_ERROR) {
            dialogRef.enableButtons(false);
            var data = {
              old_password: old_password,
              new_password: new_password,
              _token: '{{ csrf_token() }}'
            };
            $.ajax({
              url : '{{ url('/api/privilege/member/v1/password/change/'.Auth::user()->id) }}',
              method: 'post',
              dataType: 'json',
              data: data,
              success: function(data) {
                if ( data.status != 0 ) {
                  $('.login-error-message').text( data.message ).show();
                  dialogRef.enableButtons(true);
                } else {
                  swal("修改成功", "", "success");
                  dialogRef.close();
                }
              },
              error: function() {
                alert('页面出错，请刷新');
              }
            });
          }
        }
      }
    ]
  });
}
var logout = function(){
  swal({
    title: "确认退出系统",
    text: "",
    type: "warning",
    animation: "slide-from-top",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "确认",
    cancelButtonText: "取消",
    closeOnConfirm: false,
  },
  function(){
    $("#logout-a").click();
    swal("已经退出系统", "1 秒后自动跳转", "success");
    window.setTimeout(function(){
        location.href = '{{ url('') }}';
    },3000);
  });
}

</script>

</body>
</html>
