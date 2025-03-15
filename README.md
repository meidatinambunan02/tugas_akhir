1. Pull Repository

git fetch --all
git checkout revisi_proyek_mei
git pull origin revisi_proyek_mei

2. Instal Dependensi dengan Composer

Jalankan perintah berikut untuk menginstal semua package yang diperlukan:

composer install

3. Konfigurasi Environment

Buat file .env dari contoh yang ada:

cp .env.example .env

Lalu, edit file .env sesuai dengan konfigurasi database yang Anda gunakan.

4. Generate Application Key

php artisan key:generate

5. Instal Package Tambahan (barryvdh/laravel-dompdf)

Jika aplikasi menggunakan package Barryvdh Laravel DomPDF untuk membuat PDF, jalankan perintah berikut:

composer require barryvdh/laravel-dompdf

6. Jalankan Migrasi dan Seeder

Untuk membuat tabel database dan mengisi data awal:

php artisan migrate:fresh --seed

Perintah ini akan menghapus semua tabel yang ada, kemudian membuat ulang tabel berdasarkan skema migrasi, lalu mengisi data awal jika ada seeder.

7. Instal Dependensi Frontend

Jika proyek menggunakan frontend berbasis Vite atau Webpack, jalankan perintah berikut:

npm install

8. Build Assets Frontend

Jalankan perintah berikut untuk membangun aset frontend:

npm run dev


9. Menjalankan Aplikasi

Jalankan perintah berikut untuk menjalankan server Laravel:

php artisan serve

Aplikasi akan berjalan di http://127.0.0.1:8000/ secara default.

Selesai

Aplikasi Laravel Anda sekarang siap digunakan! Jika ada masalah, pastikan semua dependensi sudah terinstal dengan benar dan cek kembali konfigurasi di file .env.

