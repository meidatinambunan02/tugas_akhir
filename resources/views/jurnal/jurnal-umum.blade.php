@extends('sbadmin2.sbadmin')

@section('title')
    Jurnal Umum
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Jurnal Umum</h1>

        <!-- Tabel Jurnal Umum -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List Jurnal Umum</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode COA</th>
                                <th>Nama Akun</th>
                                <th>Deskripsi</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($jurnals as $key => $jurnal)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $jurnal->coa->kode_coa }}</td>
                                    <td>{{ $jurnal->coa->nama_akun }}</td>
                                    <td>{{ $jurnal->deskripsi }}</td>
                                    <td>{{ number_format($jurnal->debit, 2, ',', '.') }}</td>
                                    <td>{{ number_format($jurnal->kredit, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Tabel Jurnal Umum -->
    </div>
@endsection
