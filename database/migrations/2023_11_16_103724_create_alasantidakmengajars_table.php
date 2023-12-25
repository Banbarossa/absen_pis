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
        Schema::create('alasantidakmengajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensekolah_id')->constrained()->cascadeOnDelete();
            $table->text('alasan');
            $table->boolean('status')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alasantidakmengajars');
    }
};
