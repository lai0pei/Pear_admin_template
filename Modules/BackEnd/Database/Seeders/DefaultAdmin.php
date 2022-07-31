<?php

namespace Modules\BackEnd\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DefaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'account' => 'admin',
            'password' => '$2y$10$04CjIWv.SjsVTLmDcblzlu2I48JR1ns3YdUUdWi5bEXhM.gtWulqa',
            'username' => 'admin',
            'reg_ip' => request()->ip(),
            'status' => 1,
            'role_id' =>1,
            'sex' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
