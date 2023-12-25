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
        Schema::table('absensekolahs', function (Blueprint $table) {
            $table->foreignId('absenalternatif_id')->nullable()->constrained('absenalternatifs')->onDelete('set Null')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensekolahs', function (Blueprint $table) {
            $table->dropColumn('absenalternatif_id');
        });
    }
};
