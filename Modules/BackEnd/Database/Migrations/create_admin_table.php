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
        Schema::create('admin', function (Blueprint $table) {
            $table->id()->comment('管理员编号')->autoIncrement('id');
            $table->string('account',100)->comment('管理员')->default('');
            $table->string('password',200)->comment('密码')->default('');
            $table->string('username',100)->comment('昵称')->default('');
            $table->string('reg_ip', 100)->nullable()->comment('注册Ip')->default('');
            $table->string('number', 100)->nullable()->comment('联系号码')->default('');
            $table->string('mail', 100)->nullable()->comment('邮箱')->default('');
            $table->string('description', 100)->nullable()->comment('备注')->default('');
            $table->string('sex', 100)->nullable()->comment('性别 0 女, 1 男')->default('');
            $table->tinyInteger('status')->comment('1=正常，0=禁止')->default(1);
            $table->unsignedMediumInteger('role_id')->comment('角色编号')->default(0);
            $table->unsignedBigInteger('login_count')->nullable()->comment('登录次数')->default(0);
            $table->dateTime('created_at')->comment('创建时间')->default(now());
            $table->dateTime('updated_at')->comment('更新时间')->default(now());
        });
        
        $prefix = env('DB_PREFIX')."admin";
        DB::statement("alter table $prefix comment '后台管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
};
