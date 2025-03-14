<?php

namespace Database\Seeders;

use App\Models\Coa;
use Illuminate\Database\Seeder;

class CoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coa::create([
            'kode_coa' => '111',
            'nama_akun' => 'Kas',
            'header_akun' => '11',
        ]);

        Coa::create([
            'kode_coa' => '211',
            'nama_akun' => 'Piutang',
            'header_akun' => '21',
        ]);

        Coa::create([
            'kode_coa' => '411',
            'nama_akun' => 'Pendapatan',
            'header_akun' => '41',
        ]);
    }
}
