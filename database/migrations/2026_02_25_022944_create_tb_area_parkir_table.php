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
        Schema::create('tb_area_parkir', function (Blueprint $table) {
            $table->id('id_area'); // int(11) [cite: 54]
            $table->string('nama_area', 50); // varchar(50) [cite: 55]
            $table->integer('kapasitas'); // int(5) [cite: 56]
            $table->integer('terisi')->default(0); // int(5) [cite: 57]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_area_parkir');
    }
};
