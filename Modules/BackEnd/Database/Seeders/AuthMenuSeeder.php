<?php

namespace Modules\BackEnd\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AuthMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->menu() as $v) {
            $v['created_at'] = now();
            $v['updated_at'] = now();
            DB::table('auth_menu')->insert($v);
        }
    }

    private function menu(): array
    {
        return  [
            //level 1 node
            ['id' => 1, 'p_id' => 0, 'title' => "演示", 'icon' => "layui-icon layui-icon-console", 'sort' => 0, 'href' => '', 'type' => 0],
            ['id' => 2, 'p_id' => 0, 'title' => "演示2", 'icon' => "layui-icon layui-icon-component", 'sort' => 1, 'href' => '','type' => 0],
            ['id' => 3, 'p_id' => 0, 'title' => "系统管理", 'icon' => "layui-icon layui-icon-set-fill", 'sort' => 2, 'href' => '','type' => 0],
            //reserved 50 id

            //level 2 node
            ["id" => 50, 'p_id' => 3, "title" => "后台管理员", "icon" => "layui-icon layui-icon-username", 'sort'=>0,"href" => '','type' => 0],
            ["id" => 51, 'p_id' => 3, "title" => "权限管理", "icon" => "layui-icon layui-icon-template-1", 'sort'=>1,"href" => 'auth_management','type' => 1, 'is_delete'=>0],
            ["id" => 52, 'p_id' => 3, "title" => "日志管理", "icon" => "layui-icon layui-icon-log", 'sort'=>2,"href" => 'log_management','type' => 1],
            //reserved 50 id

            //level 3 node
            ["id" => 100, 'p_id' => 50, "title" => "管理员账号", "icon" => "layui-icon layui-icon-friends", 'sort'=>0,"href" => 'admin_management','type' => 1],
            ["id" => 101, 'p_id' => 50, "title" => "管理员组合", "icon" => "layui-icon layui-icon-group", 'sort'=>1,"href" => 'role_management','type' => 1],
            ["id" => 102, 'p_id' => 50, "title" => "在线管理员", "icon" => "layui-icon layui-icon-friends", 'sort'=>2,"href" => 'online_admin','type' => 1],


        ];
    }
}
