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
        Schema::create('absensekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('jam_ke')->nullable();
            $table->time('mulai_kbm')->nullable();
            $table->time('akhir_kbm')->nullable();
            $table->foreignId('rombel_id')->nullable()->constrained();
            $table->foreignId('sekolah_id')->nullable()->constrained();
            $table->foreignId('mapel_id')->nullable()->constrained();
            $table->time('waktu_absen')->nullable();
            $table->integer('keterlambatan')->nullable();
            $table->string('kehadiran')->nullable();
            $table->integer('jumlah_jam')->nullable();
            $table->boolean('in_location')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensekolahs');
    }
};
