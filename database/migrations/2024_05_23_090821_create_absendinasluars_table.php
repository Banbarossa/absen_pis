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
        Schema::create('absendinasluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absenkaryawandetail_id')->constrained()->cascadeOnDelete();
            $table->string('surat_tugas')->nullable();
            $table->text('keterangan')->nullable();
            $table->boolean('approval')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absendinasluars');
    }
};
