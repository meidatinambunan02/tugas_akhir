<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'penjualan_detail'.
     */
    public function up(): void
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id(); // Primary key otomatis (BIGINT auto increment)

            // Foreign key ke tabel 'penjualan'
            $table->foreignId('penjualan_id')
                ->constrained('penjualan') // Menghubungkan ke kolom 'id' di tabel 'penjualan'
                ->onDelete('cascade'); // Jika penjualan dihapus, detail ikut terhapus

            // Foreign key ke tabel 'obat'
            $table->foreignId('obat_id')
                ->constrained('obat') // Menghubungkan ke kolom 'id' di tabel 'obat'
                ->onDelete('cascade'); // Jika obat dihapus, detail ikut terhapus

            // Jumlah obat yang dijual (INTEGER)
            $table->integer('jmlh_jual');

            // Harga satuan saat penjualan (DECIMAL dengan presisi 12 dan skala 2)
            $table->decimal('harga_satuan', 12, 2);

            // Total harga untuk item ini (DECIMAL dengan presisi 12 dan skala 2)
            $table->decimal('total_jual', 12, 2);

            // Menyimpan waktu pembuatan dan pembaruan data
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'penjualan_detail'.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail'); // Menghapus tabel 'penjualan_detail' jika sudah ada
    }
};
