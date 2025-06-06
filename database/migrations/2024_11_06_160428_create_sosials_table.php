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
        Schema::create('sosials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nama_sosial');
            $table->string('dokumen');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->integer('nilai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosials');
    }
};
