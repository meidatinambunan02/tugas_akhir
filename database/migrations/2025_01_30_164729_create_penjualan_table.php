<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'penjualan'.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai primary key (BIGINT, auto increment)

            // Kolom untuk menyimpan nomor transaksi (harus unik)
            $table->string('no_trans')->unique(); 

            // Kolom untuk menyimpan tanggal transaksi penjualan
            $table->date('tgl_jual'); 

            // Kolom untuk menyimpan ID pelanggan (unsigned untuk tipe BIGINT)
            $table->unsignedBigInteger('pelanggan_id'); 

            // Foreign key ke tabel 'users' (untuk mencatat user yang membuat transaksi)
            $table->foreignId('user_id')
                ->constrained('users') // Menghubungkan ke kolom 'id' di tabel 'users'
                ->onDelete('cascade'); // Jika user dihapus, transaksi ikut dihapus

            // Menyimpan created_at dan updated_at secara otomatis
            $table->timestamps();

            // Membuat foreign key secara manual ke tabel 'pelanggan'
            $table->foreign('pelanggan_id')
                ->references('id') // Menghubungkan ke kolom 'id' di tabel 'pelanggan'
                ->on('pelanggan')
                ->onDelete('cascade'); // Jika pelanggan dihapus, transaksi ikut dihapus
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'penjualan'.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan'); // Menghapus tabel 'penjualan' jika sudah ada
    }
};
