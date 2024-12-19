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
        Schema::create('data', function (Blueprint $table) {
            $table->string('id_data')->primary();
            $table->string('provinsi', 100);
            $table->string('kab_kota',100);
            $table->float('presentase_pm');
            $table->decimal('pengeluaran_perkapita',16,0);
            $table->float('tingkat_pengangguran');
            $table->year('tahun');
            $table->string('klasifikasi_kemiskinan',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};