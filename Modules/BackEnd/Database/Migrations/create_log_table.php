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
        Schema::create('log', function (Blueprint $table) {
            $table->id()->comment('编号')->autoIncrement();
            $table->unsignedTinyInteger('type')->comment('日志类型')->nullable()->default(0);
            $table->string('title', 200)->comment('日志操作')->nullable()->default('');
            $table->string('ip', 200)->comment('ip 地址')->nullable()->default('');
            $table->longText('json_data')->comment('其他内容');
            $table->longText('content')->comment('日志内容')->nullable();
            $table->unsignedTinyInteger('success')->comment('0失败1成功')->nullable()->default(0);
            $table->unsignedMediumInteger('admin_id')->comment('管理员编号')->nullable()->default(0);
            $table->dateTime('created_at')->comment('创建时间')->default(now());
            $table->dateTime('updated_at')->comment('更新时间')->default(now());
        });

        $prefix = env('DB_PREFIX') . "log";
        DB::statement("alter table $prefix comment '日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
};
