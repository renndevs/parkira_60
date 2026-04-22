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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user'); // int(11) [cite: 59]
            $table->string('nama_lengkap', 50); // varchar(50) 
            $table->string('username', 50)->unique(); // varchar(50) [cite: 61]
            $table->string('password', 100); // varchar(100) [cite: 62]
            $table->enum('role', ['admin', 'petugas', 'owner']); // enum [cite: 63]
            $table->boolean('status_aktif')->default(true); // tinyint(1) [cite: 63]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
