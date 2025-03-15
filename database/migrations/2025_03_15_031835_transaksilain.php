<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'transaksi_lain'.
     */
    public function up(): void
    {
        Schema::create('transaksi_lain', function (Blueprint $table) {
            $table->id(); // Primary key otomatis (BIGINT auto increment)

            // Nomor transaksi (string) harus unik agar tidak terjadi duplikasi
            $table->string('no_trans')->unique();

            // Tanggal transaksi
            $table->date('tgl_trans');

            // Foreign key ke tabel 'coa' untuk mencatat akun terkait
            $table->foreignId('coa_id')
                ->constrained('coa') // Menghubungkan ke kolom 'id' di tabel 'coa'
                ->onDelete('cascade'); // Jika akun dihapus, transaksi ikut dihapus

            // Foreign key ke tabel 'users' untuk mencatat siapa yang membuat transaksi
            $table->foreignId('user_id')
                ->constrained('users') // Menghubungkan ke kolom 'id' di tabel 'users'
                ->onDelete('cascade'); // Jika user dihapus, transaksi ikut dihapus

            // Total nilai transaksi (dengan presisi 12, 2)
            $table->decimal('total', 12, 2);

            // Keterangan transaksi (opsional)
            $table->text('keterangan')->nullable();

            // Menyimpan waktu pembuatan dan pembaruan data
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'transaksi_lain'.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_lain'); // Menghapus tabel 'transaksi_lain' jika sudah ada
    }
};
