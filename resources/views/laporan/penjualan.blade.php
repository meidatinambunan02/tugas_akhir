@extends('sbadmin2.sbadmin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Penjualan</h1>

    <!-- Filter Periode -->
    <form action="{{ route('laporan.penjualan') }}" method="GET">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.penjualan.export', request()->all()) }}" class="btn btn-success">
                    Export PDF
                </a>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal Jual</th>
                        <th>Pelanggan</th>
                        <th>Obat</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $transaksi)
                        @foreach ($transaksi->detailPenjualan as $key => $detail)
                            <tr>
                                @if ($key === 0)
                                    <td rowspan="{{ $transaksi->detailPenjualan->count() }}">{{ $transaksi->no_trans }}</td>
                                    <td rowspan="{{ $transaksi->detailPenjualan->count() }}">{{ $transaksi->tgl_jual }}</td>
                                    <td rowspan="{{ $transaksi->detailPenjualan->count() }}">
                                        {{ optional($transaksi->pelanggan)->nama_pelanggan ?? '-' }}
                                    </td>
                                @endif
                                <td>{{ optional($detail->obat)->nama_obat ?? '-' }}</td>
                                <td>{{ $detail->harga_satuan }}</td>
                                <td>{{ $detail->jmlh_jual }}</td>
                                <td>{{ number_format($detail->total_jual, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
