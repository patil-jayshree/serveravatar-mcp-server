<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('serveravatar_user_id')->nullable()->after('password');
            $table->text('serveravatar_access_token')->nullable();
            $table->text('serveravatar_refresh_token')->nullable();
            $table->timestamp('serveravatar_token_expires_at')->nullable();
            $table->string('api_key')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'serveravatar_user_id',
                'serveravatar_access_token',
                'serveravatar_refresh_token',
                'serveravatar_token_expires_at',
                'api_key',
            ]);
        });
    }
};
