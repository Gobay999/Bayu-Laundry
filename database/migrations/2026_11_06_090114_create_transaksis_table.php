<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->text('alamat')->nullable();
            $table->string('jenis_layanan'); // Contoh: 'Cuci + Gosok', 'Bed Cover Sedang'
            $table->decimal('berat_atau_jumlah', 8, 2); // Menyimpan angka desimal (1.5 kg) atau satuan (2 pcs)
            $table->integer('total_harga'); // Hasil perkalian dengan tarif
            
            // PERBAIKAN: Mengubah tipe enum menjadi string agar bisa menerima teks status apa pun
            $table->string('status_pembayaran');
            
            $table->timestamps(); // Otomatis mencatat tanggal masuk pelanggan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};