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
            $table->integer('min_spend')->default(1); // số tiền tối thiểu để sử dụng
            $table->integer('customer_usage_limit')->default(1); // số lần người dùng đó có thể sử dụng
            $table->boolean('is_free_shipping')->default(false); // được miễn phí ship không?
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
