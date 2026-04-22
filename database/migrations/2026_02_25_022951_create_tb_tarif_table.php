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
        Schema::create('tb_tarif', function (Blueprint $table) {
            $table->id('id_tarif'); // int(11) [cite: 35]
            $table->enum('jenis_kendaraan', ['motor', 'mobil', 'lainnya']); // enum [cite: 39]
            $table->decimal('tarif_per_jam', 10, 0); // decimal(10,0) [cite: 40]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tarif');
    }
};
