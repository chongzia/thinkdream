<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 将 ticket_is_active 字段中的 0 值更新为 2
        // 以符合新的枚举值定义（1=启用, 2=禁用）
        DB::table('ticket_templates')
            ->where('ticket_is_active', 0)
            ->update(['ticket_is_active' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 回滚时将 2 值改回 0
        DB::table('ticket_templates')
            ->where('ticket_is_active', 2)
            ->update(['ticket_is_active' => 0]);
    }
};