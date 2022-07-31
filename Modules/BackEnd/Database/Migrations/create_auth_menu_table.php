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
        Schema::create('auth_menu', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedMediumInteger('p_id')->comment('父级编号')->default(0);
            $table->string('title', 100)->comment('权限名称')->default('无');
            $table->string('icon', 100)->comment('菜单图标')->default('');
            $table->string('href', 100)->comment('页面地址')->default('');
            $table->unsignedTinyInteger('is_delete')->comment('0 不可删除, 1 可删除')->default(1);
            $table->unsignedTinyInteger('type')->comment('0 目录, 1 菜单')->default(1);
            $table->unsignedTinyInteger('status')->comment('0 关闭, 1 开启')->default(1);
            $table->unsignedMediumInteger('sort')->comment('排序')->default(0);
            $table->dateTime('created_at')->comment('创建时间')->default(now());
            $table->dateTime('updated_at')->comment('更新时间')->default(now());
        });

        $prefix = env('DB_PREFIX')."auth_menu";
        DB::statement("alter table $prefix comment '用户菜单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_menu');
    }
};
