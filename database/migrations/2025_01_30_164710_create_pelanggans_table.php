<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi untuk membuat tabel 'pelanggan'.
     */
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai primary key (BIGINT, auto increment)

            // Kolom kode pelanggan, harus unik untuk mencegah duplikasi
            $table->string('kode_pelanggan')->unique(); 

            // Kolom untuk menyimpan nama pelanggan
            $table->string('nama_pelanggan'); 

            // Kolom email, harus unik agar tidak terjadi duplikasi email
            $table->string('email')->unique(); 

            // Kolom untuk menyimpan nomor telepon pelanggan
            $table->string('telepon'); 

            // Kolom untuk menyimpan alamat pelanggan (bisa berupa teks panjang)
            $table->text('alamat'); 

            // Foreign key ke tabel 'users' (untuk relasi dengan pengguna)
            $table->foreignId('user_id') 
                ->constrained('users') // Menghubungkan ke kolom 'id' di tabel 'users'
                ->onDelete('cascade'); // Jika user dihapus, data pelanggan ikut dihapus

            // Kolom created_at dan updated_at (otomatis diisi oleh Laravel)
            $table->timestamps(); 
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'pelanggan'.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan'); // Menghapus tabel 'pelanggan' jika sudah ada
    }
};
