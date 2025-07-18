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
      
    Schema::create('barang_masuks', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique();
        $table->foreignId('barang_id')->constrained()->onDelete('cascade');
        $table->date('tanggal_masuk');
        $table->integer('jumlah');
        $table->string('supplier');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
