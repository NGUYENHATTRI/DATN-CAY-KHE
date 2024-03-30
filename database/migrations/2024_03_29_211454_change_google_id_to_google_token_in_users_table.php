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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_token')->nullable()->after('google_id'); // Thêm cột google_token
            $table->string('password')->nullable()->change(); // Cho phép cột password là null
            $table->dropColumn('google_id'); // Xóa cột google_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_token'); // Xóa cột google_token
            $table->string('password')->nullable(false)->change(); // Khôi phục yêu cầu cột password không null
            $table->string('google_id')->after('email'); // Khôi phục cột google_id
        });
    }
};
