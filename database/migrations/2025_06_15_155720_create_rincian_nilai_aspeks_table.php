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
        Schema::create('rincian_nilai_aspeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komponen_id');
            $table->tinyInteger('tipe_aspek')->nullable();
            $table->foreignId('siswa_id');
            $table->foreignId('guru_id');
            $table->tinyInteger(column: 'nilai');
            $table->dateTime('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_nilai_aspeks');
    }
};
