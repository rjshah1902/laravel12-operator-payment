<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("username")->unique()->after('email');
            $table->string("contact")->after('username');
            $table->float("latitude")->after('contact');
            $table->float("longitude")->after('latitude');
            $table->text("address")->after('longitude');
            $table->tinyInteger("status")->default(1)->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('contact');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('address');
            $table->dropColumn('status');
        });
    }
};
