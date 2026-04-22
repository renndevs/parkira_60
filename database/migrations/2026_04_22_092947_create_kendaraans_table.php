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
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->id('id_kendaraan'); // int(11) [cite: 30]
            $table->string('plat_nomor', 15)->unique(); // varchar(15) [cite: 31]
            $table->string('jenis_kendaraan', 20); // varchar(20) [cite: 38]
            $table->string('warna', 20)->nullable(); // varchar(20) [cite: 42]
            $table->string('pemilik', 100)->nullable(); // varchar(100) [cite: 43]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kendaraan');
    }
};
