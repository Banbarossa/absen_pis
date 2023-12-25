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
        Schema::create('jamkaryawans_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('jamkaryawan_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('jamkaryawan_id')->references('id')->on('jamkaryawans')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['jamkaryawan_id', 'role_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamkaryawans_roles');
    }
};
