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
        Schema::table('api_log', function (Blueprint $table) {
            $table->foreignId('recharge_id')->nullable()->after('user_id')->constrained('recharge');
        });
    }

    public function down(): void
    {
        Schema::table('api_log', function (Blueprint $table) {
            $table->dropColumn('recharge_id');
        });
    }
};
