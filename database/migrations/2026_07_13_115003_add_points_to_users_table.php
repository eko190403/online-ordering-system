<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->integer('points')->default(0)->after('password');
        });
        
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'kitchen', 'customer') DEFAULT 'customer'");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'points']);
        });
        
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kasir', 'kitchen') DEFAULT 'kasir'");
    }
};
