@extends('layouts.app')
@section('content')

<style type="text/css">
/*.table tbody tr:last-child:hover {
  background-color: #f8f8f8;
}*/
.table {
  table-layout:fixed;
}
.table thead tr th {
  text-align: center;
}
.table tbody tr td {
  word-wrap:break-word;
  text-align: center;
}
.member-action {
  height: 50px;
  background-color: rgba(208,208,208,0.5);
}
.member-search {
  margin: 30px;
  text-align: right;
}
.member-search input , .member-search select {
  width: 80%;
  display: inline-block;
}
#add-new-member {
  display: none;
}
.add-error {
  position: absolute;
  margin-top: 55px;
  display: none;
}
.contents {
    padding: 5px 25px;
}
.data-privilege-div, .yewu-group-div,#data-privilege,#yewu-group {
  display: none;
}
.switch-img {
  display: inline-block;
  margin-left: 10px;
  cursor: pointer;
}
.switch-img img {
  width: 64px;
}
</style>


<div class="my-container">
  <div class="row">
    <div class="col-xs-12 member-action text-right">
      <button type="button" class="btn btn-success" style="margin-top: 8px; font-weight: bolder;" onclick="addOrEditMember();">+ 添加成员</button>
    </div>
  </div>
  
  <form action="" method="GET">
    <div class="row member-search">
      <div class="col-xs-4">
        姓名 <input type="text" class="form-control" name="name" value="{{ $name or '' }}">
      </div>
      <div class="col-xs-4">
        手机 <input type="text" class="form-control" name="phone_number" value="{{ $phone or '' }}" >
      </div>
      <div class="col-xs-4">
        邮箱 <input type="text" class="form-control" name="email" value="{{ $email or '' }}">
      </div>
      <div class="col-xs-12" style="height: 12px;"></div>
      <div class="col-xs-4">
        角色 
        <select class="form-control" name="role">
          <option value="0">请选择</option>
          @foreach ($roles as  $roleValue)
            <option value="{{ $roleValue->id }}"
            @if ( $roleValue->id == $role )
              selected 
            @endif
            role-id="{{ $roleValue->id }}" >{{ $roleValue->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-xs-4">
        状态 
        <select class="form-control" name="enable">
          <option value="-1">请选择</option>
          <option value="1" 
            @if ($enable == 1)
              selected 
            @endif
          >在职</option>
          <option value="0"
            @if ($enable == 0)
              selected 
            @endif
          >离职</option>
        </select>
      </div>
      <div class="col-xs-4" style="padding: 0;">
        <button type="submit" class="btn btn-success form-control" style="font-weight: bolder;width: 120px; margin-right: 15px;">查询</button>
      </div>
    </form>
    
  </div>

  <div class="row">
    <div class="col-xs-12" style="height: 20px;"></div>
    <div class="col-xs-12">
      <table class="table">
        <thead>
          <tr>
            <th style="width: 10%;">姓名</th>
            <th style="width: 12%;">手机</th>
            <th style="width: 20%;">邮箱</th>
            <th style="width: 15%;">角色</th>
            <th style="width: 20%;">住址</th>
            <th style="width: 8%;">状态</th>
            <th style="width: 5%;">操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->phone }}</td>
              <td>{{ $user->email }}</td>
              <td>
                sdads 
              </td>
              <td>{{ $user->address }}</td>
              <td>
                {{ $user->enable ? '在职' : '离职' }}
              </td>
              <td>
                <textarea style="display: none;" id="user-{{ $user->id }}">{{ json_encode($user) }}</textarea>
                <a onclick="addOrEditMember( $(this) ,'{{ $user->id }}');">编辑</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-xs-12 text-right">
      {{ $users->appends(['name'=>$name,'phone'=>$phone,'email'=>$email,'role'=>$role,'enable'=>$enable])->links() }}
    </div>
  </div>
  
  <div id="add-new-member">
    <div class="row contents">
      <div class="col-xs-6">姓名</div>
      <div class="col-xs-6">手机号</div>
      <div class="col-xs-6"><input type="text" class="form-control" id="add-name" placeholder="请填写真实姓名"></div>
      <div class="col-xs-6"><input type="number" class="form-control" id="add-phone-number" placeholder="请填写手机号码"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12">住址</div>
      <div class="col-xs-12"><input type="text" class="form-control" id="add-address" placeholder="请填写住址"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-6">邮箱／登录名</div>
      <div class="col-xs-4">密码(默认为：{{ $defaultPassword }})</div>
      <div class="col-xs-2">状态</div>
      <div class="col-xs-6"><input type="text" class="form-control" id="add-email" placeholder="请填个人公司邮箱" style="width: 60%; display: inline-block;"> {{ $defaultEmail }} </div>
      <div class="col-xs-4"><input type="text" class="form-control" id="add-password" value="{{ $defaultPassword }}"></div>
      <div class="col-xs-2">
        <select class="form-control" id="add-enable">
          <option value="1">在职</option>
          <option value="0">离职</option>
        </select>
      </div>
      <div class="col-xs-12" style="margin-top: 15px;">
        角色 请选择该成员担任的角色
      </div>
      <div class="col-xs-12" id="add-role" style="margin: 10px 0;">
        @foreach ($roles as $roleValue)
          <div class="col-xs-2">
            <label class="checkbox-inline">
              <input type="checkbox" class="role-class" value="{{ $roleValue->id }}" role-name="{{ $roleValue->name }}"> {{ $roleValue->name }}
            </label>
          </div>
        @endforeach  
      </div>
      <div class="col-xs-12 next-password" style="height: 15px;"></div>
    </div>
    <div class="row contents">
      <div class="col-xs-12" style="height: 15px; clear: both;"></div>
      <div class="col-xs-6 add-error">
        <img src="{{ asset('/img/2018/warn.png') }}" style="width: 20px; height: 20px;">
        <span style="color: #FF0000; margin-left: 10px;"></span>
      </div>
    </div>
  </div>
  
  <div id="password-div" style="display: none;">
    <div class="col-xs-12" style="height: 15px;"></div>
    <div class="col-xs-2" style="margin-left: -20px;">
      <label class="checkbox-inline">
        <input type="checkbox" id="check-password" value="1" style="display: none;">
        <span type="submit" class="btn btn-success form-control" style="font-weight: bolder;width: 120px; margin-right: 15px;" onclick="showPwd(this)">修改密码</span>
      </label>
    </div>    
    <div class="col-xs-4 hidden" style="display: none;">
      <input type="text" id="add-password" class="form-control" placeholder="请输入新密码">
    </div>
  </div>
</div>

<script>
var addNewMemberHtml = $('#add-new-member').html();
var passwordDivCon = $('#password-div').html();
$('#add-new-member').remove();
$('#password-div').remove(); 
function showPwd(obj) {
  var passwordSmallDiv = $(obj).parent().parent().next();
  if(passwordSmallDiv.hasClass('hidden')){
    $(obj).html("放弃修改");
    $(obj).attr('class','btn btn-danger form-control');
    passwordSmallDiv.attr('class','col-xs-4 show');
    passwordSmallDiv.show();
  }else{
    $(obj).html("修改密码");
    $(obj).attr('class','btn btn-success form-control');
    passwordSmallDiv.attr('class','col-xs-4 hidden');
    passwordSmallDiv.hide();
  }
}
var addOrEditMember = function(self,id)
{
  var title = '添加成员';
  var label = '添加';
  var url = '{{ url('/api/privilege/member/v1/add') }}';
  if(id){
    title = '编辑成员';
    label = '保存';
    url   = '{{ url('/api/privilege/member/v1/change') }}'+'/'+id;
  } else {
    // swal("MIS 系统添加账户功能已经关闭，请联系 HR 添加账号", "");
    // return false;
  }
  var dialog =  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_PRIMARY,
    title: title,
    message: addNewMemberHtml,
    size : BootstrapDialog.SIZE_WIDE,
    nl2br: false,
    cssClass: 'plans-dialog',
    onshown: function(dialogRef){
      if(id){
        var userMsg = JSON.parse($("#user-"+id).text());
        var isShowManagerDiv = false;
        $("#add-name").val(userMsg.name);
        $("#add-phone-number").val(userMsg.phone);

        $("#add-email").val(userMsg.email.split('@')[0]);
        //密码框处理
        $("#add-password").parent().prev().prev().prev().remove();
        $("#add-password").parent().remove();
        $("#add-password").remove();
        var passwordDiv = $("<div>");
        passwordDiv.html(passwordDivCon);
        $(".next-password").after(passwordDiv);

        if ( userMsg.role ) {
          var roleArr = userMsg.role.split(",");
          var roleNameArr = userMsg.roleArr;
          $('#add-role').find('input[type="checkbox"]').each(function(){ 
            if( roleArr.indexOf($(this).val()) > -1 ) {
              $(this).attr("checked","checked");
            }
          });
        }

        $("#add-address").val(userMsg.address);
        $("#add-enable").val(userMsg.enable);
        $("#add-name").attr("readonly","readonly");
        $("#add-email").attr("readonly","readonly");
      }

      // 角色添加点击动作
      $(".role-class").click(function(event) {
        var roleNameArr = [];
        $('#add-role').find('input[type="checkbox"]:checked').each(function(){ 
          roleNameArr.push($(this).attr('role-name'));
        });
      });
    },
    buttons: [
      {
        label: '取消',
        action: function(dialogItself){
          dialogItself.close();
        }
      },
      {
        label: label,
        cssClass: 'btn-primary',
        action: function(dialogRef) {
          var hasError = false;
          var name = $("#add-name").val();
          var phone = $("#add-phone-number").val();
          var address = $("#add-address").val();
          var email = $("#add-email").val();
          var checkPwd = false;
          if(id){
            checkPwd = $("#check-password").prop("checked");
            if(checkPwd){
              var password = $("#add-password").val();
            }
          }else{
            var password = $("#add-password").val();
            checkPwd = true;
          }
          var enable = $("#add-enable").val();
          var role = new Array;
          $('#add-role').find('input[type="checkbox"]:checked').each(function(){ 
            role.push($(this).val()); 
          });
          

          if( name === '' ) {
            $(".add-error").find('span').html('姓名不能为空');
            $(".add-error").show();
            hasError = true;
          } else if( phone === '' || phone.length != 11 ) {
            $(".add-error").find('span').html('电话不能为空且必须为11位');
            $(".add-error").show();
            hasError = true;
          } else if( email === '' ) {
            $(".add-error").find('span').html('邮箱不能为空');
            $(".add-error").show();
            hasError = true;
          } else if( role.length === 0 ) {
            $(".add-error").find('span').html('请选择一个角色');
            $(".add-error").show();
            hasError = true;
          } else {
            if( undefined !== password ){
              var re = /^[a-zA-Z0-9]{8,20}$/;
              var pwdFlag = 1;
              if(re.test(password)){
                pwdFlag = 0;
              }
              if( password === '' || pwdFlag ) {
                $(".add-error").find('span').html('密码不能为空且必须为8-20位数字字母组合');
                $(".add-error").show();
                hasError = true;
              }
            } 
          }

          var roleIds   = ','+role.join(",")+',';
          var sendData = {
            name : name,
            phone : phone,
            address : address,
            email : email+"{{ $defaultEmail }}",
            enable : enable,
            role : roleIds,
            _token: "{{ csrf_token() }}"
          };

          if( checkPwd ) {
            sendData.password = password;
          }

          if( ! hasError ) {
            dialogRef.enableButtons(false);
            $.ajax({
              url: url,
              method: 'post',
              dataType: 'json',  
              data: sendData,
              success: function(data) {
                if( data.status === 0 ) {
                  $(".add-error").hide();
                  localStorage.setItem("remindMessage",title + "成功！");
                  location.reload();
                } else {
                  dialogRef.enableButtons(true);
                  $(".add-error").find('span').html(data.message);
                  $(".add-error").show();
                }
              },
              error: function() {
                swal("提交出错，请刷新o(╯□╰)o", "", "error");
              }
            });
          }

        }
      }
    ]
  });
}

</script>

@endsection