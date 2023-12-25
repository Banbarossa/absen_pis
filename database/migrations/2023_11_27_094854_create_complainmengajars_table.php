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
        Schema::create('complainmengajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensekolah_id')->constrained()->cascadeOnDelete();
            $table->string('change_to');
            $table->text('reason');
            $table->string('status')->nullable();
            $table->foreignId('approved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complainmengajars');
    }
};
