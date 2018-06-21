## 简介
  利用laravel5.5.39 和 adminLTE 组合的后台管理系统

## 基本特性
- **包含系统成员管理、角色管理、角色权限管理**
- **支持后台用户修改基本信息，包括头像、电话，地址等信息**
- **支持用户包含多个角色**
- **实现权限控制，权限分为菜单权限、功能权限**

## 安装
- 使用git克隆整个项目，并将bootstrap/cache/* ，storage/* 权限设置为777；
- 执行composer install，处理了依赖关系，下载相关安装包；
- 在public目录下建立sys_images，并将权限赋为777。
- 生成application encryption，php artisan key:generate
- 创建对应数据库。php artisan migrate
- 进行数据填充，php artisan db:seed
- 生成后台的登录账户密码：admin@ooxx.com、123456

## 截图展示
<img src="https://github.com/lufeijun/adminSys/blob/master/public/img/2018/home.png">
<img src="https://github.com/lufeijun/adminSys/blob/master/public/img/2018/role.png">
