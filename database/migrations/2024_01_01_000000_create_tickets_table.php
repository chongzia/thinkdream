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
            $table->id();
            $table->string('ticket_no')->comment('工单编号');
            $table->string('ticket_name')->comment('工单标题');
            $table->integer('ticket_status')->default(1)->comment('工单状态 (1:待处理, 2:处理中, 3:已完成, 4:已关闭)');
            $table->integer('ticket_priority')->default(2)->comment('优先级 (1:低, 2:中, 3:高, 4:特)');
            $table->integer('ticket_promoter')->comment('工单发起人');
            $table->integer('ticket_accept_at')->nullable()->comment('工单受理日期');
            $table->integer('ticket_accept_overdue')->default(0)->comment('工单受理超期 (0:未超期, 1:超期)');
            $table->integer('ticket_accept_days')->default(1)->comment('工单受理天数');
            $table->integer('ticket_process_at')->nullable()->comment('工单流程日期');
            $table->integer('ticket_process_overdue')->default(0)->comment('工单流程超期 (0:未超期, 1:超期)');
            $table->integer('ticket_process_days')->default(3)->comment('工单处理天数');
            $table->integer('ticket_node_id')->default(1)->comment('工单节点');
            $table->integer('ticket_node_accept')->comment('工单受理人');
            $table->text('ticket_node_process')->nullable()->comment('工单流程人');
            $table->integer('ticket_process_position')->default(1)->comment('工单流程人当前位置');
            $table->integer('ticket_template')->comment('工单模板');
            $table->text('ticket_data')->nullable()->comment('工单数据');
            $table->integer('created_at')->comment('创建时间');
            $table->integer('updated_at')->comment('更新时间');
            $table->integer('closed_at')->nullable()->comment('关闭时间');
            
            // 索引
            $table->index('ticket_no');
            $table->index('ticket_status');
            $table->index('ticket_priority');
            $table->index('ticket_promoter');
            $table->index('ticket_template');
            $table->index('created_at');
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