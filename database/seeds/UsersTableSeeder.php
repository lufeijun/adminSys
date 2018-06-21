<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // 插入用户
      \DB::table('users')->insert([
          'name' => 'admin',
          'email' => 'admin@ooxx.com',
          'password' => bcrypt('123456'),
          'address' => '管理员地址',
          'role' => ',1,',
          'enable' => '1',
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s'),
      ]);

      // 插入角色
      \DB::table('roles')->insert([
        'name' => '管理员',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);

      // 插入权限
      \DB::table('abilities')->insert([
        'role_id' => '1',
        'ability' => '权限,角色管理,角色列表',
        'type' => '1',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);

      \DB::table('abilities')->insert([
        'role_id' => '1',
        'ability' => '权限,成员管理,成员列表',
        'type' => '1',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]);
    }
}
