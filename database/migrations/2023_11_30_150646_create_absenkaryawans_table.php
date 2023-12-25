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
        Schema::create('absenkaryawans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jamkaryawan_id')->nullable();
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->time('scan_masuk');
            $table->time('scan_pulang');
            $table->integer('terlambat')->nullable();
            $table->integer('pulang_cepat')->nullable();
            $table->integer('selisih_waktu')->nullable();

            $table->boolean('masuk_in_location')->nullable();
            $table->decimal('masuk_latitude', 10, 6)->nullable();
            $table->decimal('masuk_longitude', 10, 6)->nullable();

            $table->boolean('pulang_in_location')->nullable();
            $table->decimal('pulang_latitude', 10, 6)->nullable();
            $table->decimal('pulang_longitude', 10, 6)->nullable();

            $table->string('masuk_image')->nullable();
            $table->string('pulang_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absenkaryawans');
    }
};
