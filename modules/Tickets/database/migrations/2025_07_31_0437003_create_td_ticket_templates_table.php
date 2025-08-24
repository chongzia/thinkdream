<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ticket_name', 255)->comment('模板名称');
            $table->string('ticket_description', 255)->nullable()->comment('模板描述');
            $table->text('ticket_form')->comment('模板表单');
            $table->unsignedBigInteger('ticket_accept')->comment('模板受理人');
            $table->string('ticket_process', 255)->comment('模板流程人');
            $table->unsignedTinyInteger('ticket_accept_days')->default(3)->comment('模板受理天数');
            $table->unsignedTinyInteger('ticket_process_days')->default(7)->comment('模板处理天数');
            $table->unsignedTinyInteger('ticket_is_active')->default(1)->comment('模板启用');
            $table->unsignedInteger('created_at')->comment('创建时间');
            $table->unsignedInteger('updated_at')->comment('更新时间');

            // 创建索引
            $table->index('ticket_name', 'idx_template_name');
            $table->index('ticket_is_active', 'idx_template_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_templates');
    }
};