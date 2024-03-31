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
        Schema::table('voucher_type', function (Blueprint $table) {
            $table->string('discount_type', 191)->default('flat')->comment('flat/percentage'); // Thêm cột discount_type với giá trị mặc định là 'flat'
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
