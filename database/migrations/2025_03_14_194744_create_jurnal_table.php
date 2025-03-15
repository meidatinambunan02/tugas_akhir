<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi untuk membuat tabel 'jurnal'.
     */
    public function up(): void
    {
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id(); // Primary key otomatis (BIGINT auto increment)

            // Nomor jurnal (string), bisa digunakan untuk referensi
            $table->string('no_jurnal');

            // Tanggal pencatatan jurnal
            $table->date('tgl_jurnal');

            // Foreign key ke tabel 'coa' untuk mencatat akun terkait
            $table->foreignId('coa_id')
                ->constrained('coa') // Menghubungkan ke kolom 'id' di tabel 'coa'
                ->onDelete('cascade'); // Jika akun dihapus, jurnal ikut dihapus

            // Deskripsi transaksi atau jurnal
            $table->string('deskripsi');

            // Nilai debit (tidak boleh negatif), default = 0
            $table->decimal('debit', 15, 2)->default(0);

            // Nilai kredit (tidak boleh negatif), default = 0
            $table->decimal('kredit', 15, 2)->default(0);

            // Foreign key ke tabel 'users' untuk mencatat siapa yang membuat jurnal
            $table->foreignId('user_id')
                ->constrained('users') // Menghubungkan ke kolom 'id' di tabel 'users'
                ->onDelete('cascade'); // Jika user dihapus, jurnal ikut dihapus

            // Menyimpan waktu pembuatan dan pembaruan data
            $table->timestamps();
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'jurnal'.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal'); // Menghapus tabel 'jurnal' jika sudah ada
    }
};
