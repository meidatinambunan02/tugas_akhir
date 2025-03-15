@extends('sbadmin2.sbadmin')

@section('title')
    Buku Besar
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buku Besar</h1>

    <!-- Loop untuk setiap Kode COA -->
    @foreach ($bukuBesar->groupBy('kode_coa') as $kodeCoa => $entries)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ $kodeCoa }} - {{ $entries->first()['nama_akun'] }}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $key => $entry)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($entry['tanggal'])->format('d-m-Y') }}</td>
                                    <td>{{ $entry['deskripsi'] }}</td>
                                    <td>{{ number_format($entry['debit'], 2, ',', '.') }}</td>
                                    <td>{{ number_format($entry['kredit'], 2, ',', '.') }}</td>
                                    <td>{{ number_format($entry['saldo'], 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
