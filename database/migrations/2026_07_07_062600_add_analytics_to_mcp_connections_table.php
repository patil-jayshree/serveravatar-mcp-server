<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mcp_connections', function (Blueprint $table) {
            $table->unsignedBigInteger('request_count')->default(0)->after('last_activity_at');
            $table->unsignedBigInteger('tool_call_count')->default(0)->after('request_count');
            $table->unsignedBigInteger('success_count')->default(0)->after('tool_call_count');
            $table->unsignedBigInteger('error_count')->default(0)->after('success_count');
            $table->unsignedBigInteger('total_response_time_ms')->default(0)->after('error_count');
            $table->timestamp('first_request_at')->nullable()->after('total_response_time_ms');
            $table->timestamp('last_request_at')->nullable()->after('first_request_at');
        });
    }

    public function down(): void
    {
        Schema::table('mcp_connections', function (Blueprint $table) {
            $table->dropColumn([
                'request_count',
                'tool_call_count',
                'success_count',
                'error_count',
                'total_response_time_ms',
                'first_request_at',
                'last_request_at',
            ]);
        });
    }
};
