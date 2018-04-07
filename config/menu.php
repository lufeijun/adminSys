<?php
// 左侧菜单栏
return [
  'menu' => [
    '权限' => [ // 横向导航栏
      '成员管理' => [
        'check' => '权限,成员管理',// 检测二级菜单 与 ability 中的menuTree对应
        'controllers' => ['MemberListController'], // 对应的控制器，包含的话则展开
        'image' => 'member.png', // 二级菜单左侧图片 目前用bootstrop类
        'threeMenu' => [ //三级菜单
          //检测权限与menuTree对应           二级菜单名字          对应的URL              对应的微章提示
          ['check'=>'权限,成员管理,成员列表','name'=>'成员列表','url'=>'admin/privilege/member/list','badge'=>'','current'=>['admin/privilege/member/list']],
        ],
      ],
      '角色管理' => [
        'check' => '权限,角色管理',
        'controllers' => ['RoleController'],
        'image' => 'role.png',
        'threeMenu' => [
          ['check'=>'权限,角色管理,角色列表','name'=>'角色列表','url'=>'admin/privilege/role/list','badge'=>'','current'=>['admin/privilege/role']],
        ],
      ],
    ],
  ],

  // 一级菜单对应关系
  'first' => [
    'privilege' => '权限',
  ],

];