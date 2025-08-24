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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('工单ID');
            $table->string('ticket_no', 255)->comment('工单编号');
            $table->string('ticket_name', 255)->comment('工单标题');
            $table->unsignedTinyInteger('ticket_status')->default(1)->comment('工单状态');
            $table->unsignedTinyInteger('ticket_priority')->default(1)->comment('工单优先级');
            $table->unsignedBigInteger('ticket_promoter')->comment('工单发起人');
            $table->unsignedInteger('ticket_accept_at')->nullable()->comment('工单受理日期');
            $table->unsignedInteger('ticket_accept_days')->default(3)->comment('工单受理天数');
            $table->unsignedInteger('ticket_process_at')->nullable()->comment('工单流程日期');
            $table->unsignedInteger('ticket_process_days')->default(7)->comment('工单处理天数');
            $table->unsignedBigInteger('ticket_node_id')->comment('工单节点');
            $table->unsignedBigInteger('ticket_node_accept')->comment('工单受理人');
            $table->string('ticket_node_process', 255)->nullable()->comment('工单流程人');
            $table->unsignedBigInteger('ticket_template')->comment('工单模板');
            $table->text('ticket_data')->comment('工单数据');
            $table->unsignedInteger('created_at')->comment('创建时间');
            $table->unsignedInteger('updated_at')->comment('更新时间');
            $table->unsignedInteger('closed_at')->nullable()->comment('关闭时间');

            // 创建唯一索引
            $table->unique('ticket_no', 'idx_ticket_no');
            
            // 创建普通索引
            $table->index('ticket_status', 'idx_ticket_status');
            $table->index('ticket_promoter', 'idx_ticket_promoter');
            $table->index('ticket_node_accept', 'idx_ticket_node_accept');
            $table->index('ticket_template', 'idx_ticket_template');
            $table->index('ticket_node_id', 'idx_ticket_node_id');
            $table->index('created_at', 'idx_created_at');
            
            // 创建组合索引
            $table->index(['ticket_status', 'ticket_priority'], 'idx_status_priority');
            $table->index(['ticket_node_accept', 'ticket_status'], 'idx_accept_status');
            $table->index(['ticket_promoter', 'created_at'], 'idx_promoter_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};