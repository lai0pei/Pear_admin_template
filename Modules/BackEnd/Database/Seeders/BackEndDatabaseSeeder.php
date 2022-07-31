<?php

namespace Modules\BackEnd\Database\Seeders;

use Illuminate\Database\Seeder;

class BackEndDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AuthMenuSeeder::class,   
            DefaultRole::class,
            DefaultAdmin::class,        
        ]);
    }
}
