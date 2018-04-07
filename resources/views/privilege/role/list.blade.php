@extends('layouts.app')
@section('content')

<style type="text/css">
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
.role-action {
  height: 50px;
  background-color: rgba(208,208,208,0.5);
}
.role-search {
  margin: 30px;
  text-align: right;
}
.role-search input , .role-search select {
  width: 80%; 
  display: inline-block;
}
#add-new-member {
  display: none;
}
#add-error {
  margin-top: 96px;
  position: absolute;
}
</style>


<div class="my-container">
  <div class="row">
    <div class="col-xs-12 member-action text-right">
      <button type="button" class="btn btn-success" style="margin-top: 8px; font-weight: bolder;" onclick="addOrEditRole();">+ 添加角色</button>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12" style="height: 20px;"></div>
    <div class="col-xs-12">
      <table class="table">
        <thead>
          <tr>
            <th style="width: 20%;"></th>
            <th style="width: 20%;">编号</th>
            <th style="width: 20%;">角色</th>
            <th style="width: 20%;">操作</th>
            <th style="width: 20%;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
            <tr>
              <td></td>
              <td>{{ $role->id }}</td>
              <td>{{ $role->name }}</td>
              <td>
                <a onclick="addOrEditRole($(this),'{{ $role->id }}')" role-name="{{ $role->name }}">编辑角色</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="{{ url('/admin/privilege/role/permit/show/'.$role->id) }}">编辑权限</a>
              </td>
              <td></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  
  <div id="add-new-role">
    <div class="row contents">
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12"><input type="text" class="form-control" id="role-name" placeholder="请填写角色名称"></div>
      <div class="col-xs-12" style="height: 15px;"></div>
      <div class="col-xs-12" id="add-error" style="display: none;">
        <img src="{{ asset('/img/2018/warn.png') }}" style="width: 20px; height: 20px;">
        <span style="color: #FF0000; margin-left: 10px;"></span>
      </div>
    </div>
  </div>


</div>

<script>
var addOrEditHtml = $('#add-new-role').html();
$('#add-new-role').remove();
var addOrEditRole = function(self,id)
{
  var title = '添加';
  var url   = '{{ url('/api/privilege/role/v1/add') }}';
  if (id) {
    title = "编辑";
    url = '{{ url('/api/privilege/role/v1/edit') }}'+'/'+id;
  }
  
  var dialog =  BootstrapDialog.show({
    type: BootstrapDialog.TYPE_PRIMARY,
    title: title + '角色',
    message: addOrEditHtml,
    size : BootstrapDialog.SIZE_WIDE,
    nl2br: false,
    cssClass: 'plans-dialog',
    onshown: function(dialogRef){
      if (id) {
        $("#role-name").val(self.attr('role-name'));
      }
    },
    buttons: [
      {
        label: '取消',
        action: function(dialogItself){
            dialogItself.close();
        }
      },
      {
        label: title,
        cssClass: 'btn-primary',
        action: function(dialogRef) {
          var hasError = false;
          var name = $('#role-name').val();
          if( name === '' ) {
            if( !hasError ) {
              $("#add-error").find('span').html('角色名不能为空');
              $("#add-error").show();
              hasError = true;
            }
          }
          if( ! hasError ) {
            $.ajax({
              url: url,
              method: 'post',
              dataType: 'json',  
              data: {
                name : name,
                _token: '{{ csrf_token() }}'
              },
              success: function(data) {
                if( data.status === 0 ) {
                  $("#add-error").hide();
                  swal( title + "成功！", "1秒后自动刷新", "success");
                  window.setTimeout(function(){
                    location.reload();
                  },1000);
                } else {
                  $("#add-error").find('span').html(data.message);
                  $("#add-error").show();
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