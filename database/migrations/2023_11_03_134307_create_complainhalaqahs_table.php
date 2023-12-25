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
        Schema::create('complainhalaqahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absenhalaqah_id')->constrained()->cascadeOnDelete();
            $table->string('change_to');
            $table->text('reason');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complainhalaqahs');
    }
};
