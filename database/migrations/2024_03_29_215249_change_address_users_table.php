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
            // Xoá cột 'address'
            $table->dropColumn('address');

            // Thêm cột 'province_id'
            $table->unsignedBigInteger('province_id')->nullable();
            // Thêm ràng buộc khóa ngoại tới bảng 'provinces'
            $table->foreign('province_id')->references('code')->on('provinces');

            // Thêm cột 'district_id'
            $table->unsignedBigInteger('district_id')->nullable();
            // Thêm ràng buộc khóa ngoại tới bảng 'districts'
            $table->foreign('district_id')->references('code')->on('districts');

            // Thêm cột 'ward_id'
            $table->unsignedBigInteger('ward_id')->nullable();
            // Thêm ràng buộc khóa ngoại tới bảng 'wards'
            $table->foreign('ward_id')->references('code')->on('wards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
