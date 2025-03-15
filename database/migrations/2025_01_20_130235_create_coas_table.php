<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel 'coa'.
     */
    public function up(): void
    {
        Schema::create('coa', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' sebagai primary key dengan tipe data BIGINT (auto increment)
            $table->integer('kode_coa'); // Kolom untuk menyimpan kode akun (Chart of Account)
            $table->string('nama_akun'); // Kolom untuk menyimpan nama akun
            $table->integer('header_akun')->nullable(); // Kolom untuk menyimpan header akun (bisa bernilai null)
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Membatalkan migrasi dengan menghapus tabel 'coa'.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa'); // Menghapus tabel 'coa' jika tabel tersebut ada
    }
};
