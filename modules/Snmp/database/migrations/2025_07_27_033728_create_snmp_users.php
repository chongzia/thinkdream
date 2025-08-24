<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (Schema::hasTable('snmp_users')) {
            return;
        }
        Schema::create('snmp_users', function (Blueprint $table) {
            $table->id()->comment('编号');
            $table->string('name', 32)->comment('姓名');
            $table->string('phone', 11)->comment('电话');
            $table->integer('area_id')->comment('区域id');
            $table->integer('department_id')->comment('部门id');
            $table->string('device_name', 255)->comment('设备名称');
            $table->string('device_ip', 15)->comment('设备ip');
            $table->string('device_mac', 17)->comment('设备mac');
            $table->tinyInteger('device_authorize')->comment('设备授权');
            $table->tinyText('device_apply')->comment('设备申请');
            $table->tinyText('device_deal')->comment('设备受理');
            $table->tinyInteger('device_deal_status')->comment('设备受理状态');
            $table->createdAt();
            $table->updatedAt();
            $table->engine = 'InnoDB';
            $table->comment('使用者');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('snmp_users');
    }
};
