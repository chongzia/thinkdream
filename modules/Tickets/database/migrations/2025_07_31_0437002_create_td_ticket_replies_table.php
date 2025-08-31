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
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('回复ID');
            $table->unsignedBigInteger('ticket_id')->comment('工单ID');
            $table->unsignedTinyInteger('ticket_accept_status')->comment('受理状态');
            $table->text('ticket_content')->comment('回复内容');
            $table->unsignedBigInteger('ticket_user_id')->comment('回复人ID');
            $table->unsignedInteger('created_at')->comment('创建时间');
            $table->unsignedInteger('updated_at')->comment('更新时间');

            // 创建索引
            $table->index('ticket_id', 'idx_reply_ticket_id');
            $table->index('ticket_user_id', 'idx_reply_user_id');
            $table->index('ticket_accept_status', 'idx_reply_status');
            $table->index('created_at', 'idx_reply_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};