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
        Schema::table('ticket_templates', function (Blueprint $table) {
            // 修改ticket_form字段为可空，支持分步操作
            $table->text('ticket_form')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_templates', function (Blueprint $table) {
            // 回滚时改回必填
            $table->text('ticket_form')->nullable(false)->change();
        });
    }
};