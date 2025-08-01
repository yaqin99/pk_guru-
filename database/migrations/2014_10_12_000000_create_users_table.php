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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user');
            $table->string('nip')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tempat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('email')->nullable();
            $table->string('poin')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('mapel_id')->nullable();
            $table->tinyInteger('kelas')->nullable();
            $table->string('username');
            $table->string('password');
            $table->integer('role');
            $table->string(column: 'status_kepegawaian');
            $table->date('tanggal');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
