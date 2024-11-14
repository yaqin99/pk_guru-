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
        Schema::create('aspeks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_kinerja_id');
            $table->integer('pedagogik')->nullable();
            $table->integer('kepribadian')->nullable();
            $table->integer('profesional')->nullable();
            $table->integer('sosial')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspeks');
    }
};
