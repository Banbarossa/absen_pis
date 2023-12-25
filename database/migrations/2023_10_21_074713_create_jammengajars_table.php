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
        Schema::create('jammengajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->integer('hari');
            $table->string('jam_ke');
            $table->time('mulai_kbm');
            $table->time('akhir_kbm');
            $table->time('mulai_absen');
            $table->time('akhir_absen');
            $table->integer('jumlah_jam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jammengajars');
    }
};
