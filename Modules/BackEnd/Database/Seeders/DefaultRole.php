<?php

namespace Modules\BackEnd\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DefaultRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_name' => '超级管理员',
            'status' => 1,
            'description' => '责任大, 事情多',
            'auth_id' => $this->getAllPermission(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getAllPermission(){
        return implode(',',array_column(DB::table('auth_menu')->select('id')->get()->toArray(),'id'));
    }
}
