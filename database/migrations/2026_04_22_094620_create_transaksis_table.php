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
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir'); // int(11) [cite: 36]
            $table->foreignId('id_kendaraan')->references('id_kendaraan')->on('tb_kendaraan')->onDelete('cascade'); // int(11) [cite: 37]
            $table->foreignId('id_tarif')->nullable()->references('id_tarif')->on('tb_tarif')->onDelete('set null'); // int(11) [cite: 46]
            $table->foreignId('id_user')->nullable()->references('id_user')->on('tb_user')->onDelete('set null'); // int(11) [cite: 51]
            $table->foreignId('id_area')->nullable()->references('id_area')->on('tb_area_parkir')->onDelete('set null'); // int(11) [cite: 52]

            $table->dateTime('waktu_masuk'); // datetime [cite: 41]
            $table->dateTime('waktu_keluar')->nullable(); // datetime [cite: 45]
            $table->integer('durasi_jam')->nullable(); // int(5) [cite: 47]
            $table->decimal('biaya_total', 10, 0)->nullable(); // decimal(10,0) [cite: 49]
            $table->enum('status', ['masuk', 'keluar'])->default('masuk'); // enum [cite: 50]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi');
    }
};
