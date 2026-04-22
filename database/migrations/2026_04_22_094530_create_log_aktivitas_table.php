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
        Schema::create('tb_log_aktivitas', function (Blueprint $table) {
            $table->id('id_log'); // int(11) [cite: 65]
            $table->foreignId('id_user')->references('id_user')->on('tb_user')->onDelete('cascade'); // int(11) [cite: 66]
            $table->string('aktivitas', 100); // varchar(100) [cite: 67]
            $table->dateTime('waktu_aktivitas'); // datetime [cite: 68]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_log_aktivitas');
    }
};
