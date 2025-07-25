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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->string('merk_type');
            $table->integer('jumlah')->default(0);
            $table->string('satuan');
            $table->string('sumber_barang');
            $table->integer('harga_barang');
            $table->string('status')->default('tersedia');
            $table->integer('stok')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategoris')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
