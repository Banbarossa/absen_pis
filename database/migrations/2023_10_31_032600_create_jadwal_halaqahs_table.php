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
        Schema::create('jadwal_halaqahs', function (Blueprint $table) {
            $table->id();
            $table->integer('hari');
            $table->string('nama_sesi');
            $table->time('mulai_absen');
            $table->time('akhir_absen');
            $table->integer('insentif');
            // $table->boolean('is_aktif')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_halaqahs');
    }
};
