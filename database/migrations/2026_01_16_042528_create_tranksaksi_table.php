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
        Schema::create('tranksaksi', function (Blueprint $table) {
            $table->id('id_tranksaksi');
            $table->string('kode_transaksi'); // 👈 TAMBAHAN
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_produk'); // diasumsikan mengacu ke barang
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->integer('total');
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('id_pelanggan')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_barang')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tranksaksi');
    }
};
