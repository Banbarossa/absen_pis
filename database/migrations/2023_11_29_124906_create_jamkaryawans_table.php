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
        Schema::create('jamkaryawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jam_kerja');
            $table->time('jam_masuk_1');
            $table->time('mulai_absen_masuk_1');
            $table->time('akhir_absen_masuk_1');
            $table->time('jam_masuk_2');
            $table->time('mulai_absen_masuk_2');
            $table->time('akhir_absen_masuk_2');
            $table->time('jam_pulang');
            $table->time('mulai_absen_pulang');
            $table->time('akhir_absen_pulang');
            $table->integer('toleransi');
            $table->boolean('ischeckouttomorrow')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jamkaryawans');
    }
};
