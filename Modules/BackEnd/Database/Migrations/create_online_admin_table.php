<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_admin', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement('id');
            $table->string('admin_id',100)->comment('管理员编号')->default('');
            $table->string('last_ip', 100)->nullable()->comment('登录Ip')->default('');
            $table->rememberToken()->nullable()->comment('登录token储存')->default('');
            $table->dateTime('last_date')->nullable()->comment('最后登录时间');
            $table->dateTime('created_at')->comment('创建时间')->default(now());
            $table->dateTime('updated_at')->comment('更新时间')->default(now());
        });
        
        $prefix = env('DB_PREFIX')."online_admin";
        DB::statement("alter table $prefix comment '在线后台管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_admin');
    }
};
