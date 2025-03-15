<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'obat'.
     */
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai primary key (BIGINT, auto increment)
            $table->string('kode_obat'); // Kolom untuk menyimpan kode obat (STRING)
            $table->string('nama_obat'); // Kolom untuk menyimpan nama obat (STRING)
            $table->integer('jmlh_stok'); // Kolom untuk menyimpan jumlah stok (INTEGER)
            $table->integer('harga'); // Kolom untuk menyimpan harga obat (INTEGER)
            $table->date('tgl_beli'); // Kolom untuk menyimpan tanggal pembelian obat (DATE)
            $table->foreignId('user_id') // Membuat kolom foreign key ke tabel 'users'
                ->constrained('users') // Menghubungkan ke kolom 'id' di tabel 'users'
                ->onDelete('cascade'); // Jika data user dihapus, data ini ikut terhapus
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at (TIMESTAMP)
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'obat'.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat'); // Menghapus tabel 'obat' jika sudah ada
    }
};
