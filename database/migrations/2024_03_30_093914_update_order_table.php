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
        Schema::table('order', function (Blueprint $table) {
            $table->string('province_id', 20)->nullable();
            $table->foreign('province_id')->references('code')->on('provinces');
            $table->string('district_id', 20)->nullable();
            $table->foreign('district_id')->references('code')->on('districts');
            $table->string('ward_id', 20)->nullable();
            $table->foreign('ward_id')->references('code')->on('wards');
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->integer('coupon_discount_amount')->default(0);
            $table->text('note')->nullable();
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
