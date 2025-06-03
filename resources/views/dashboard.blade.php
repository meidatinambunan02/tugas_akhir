@extends('sbadmin2.sbadmin')
<!-- ✅ Menggunakan template utama dari SB Admin -->

@section('title')
Dashboard Apotek Milan
@endsection

@section('content')
<div class="container-fluid">
    <!--  Judul Halaman -->
    <h1 class="h3 mb-4 text-gray-800">Dashboard Apotek Milan</h1>

    <!-- ✅ Row Summary -->
    <div class="row">
        <!-- ✅ Total Penjualan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Penjualan
                    </div>
                    <!-- ✅ Format angka ke bentuk mata uang (Rupiah) -->
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPenjualan) }}</div>
                </div>
            </div>
        </div>

        <!-- ✅ Total Pembelian -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Total Pembelian
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPembelian) }}</div>
                </div>
            </div>
        </div>

        <!-- ✅ Total Aset -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Total Aset
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalAset) }}</div>
                </div>
            </div>
        </div>

        <!-- ✅ Pelanggan Aktif -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Pelanggan Aktif
                    </div>
                    <!-- ✅ Menampilkan jumlah pelanggan aktif -->
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pelangganAktif }}</div>
                </div>
            </div>
        </div>

        <!-- ✅ Pendapatan Bersih -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pendapatan Bersih
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($pendapatanBersih) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Transaksi Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaksi Terbaru</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th> <!-- ✅ Menampilkan tanggal transaksi -->
                          <!-- ✅ Menampilkan nama pelanggan --> 
                        <th>Total</th> <!-- ✅ Menampilkan total transaksi -->
                    </tr>
                </thead>
                <tbody>
                    <!-- ✅ Looping data transaksi terbaru -->
                    @foreach ($transaksiTerbaru as $transaksi)
                    <tr>
                        <td>{{ $transaksi->tgl_jual }}</td>
                        <!-- ✅ Mengambil nama pelanggan dari relasi -->
                      {{--  <td>{{ $transaksi->pelanggan->nama_pelanggan }}</td> --}}
                        <!-- ✅ Menampilkan total transaksi (jika ada) -->
                        <td>Rp {{ number_format(optional($transaksi->detailPenjualan->first())->total_jual ?? 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ✅ Stok Obat Hampir Habis -->
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">
         {{--   <h6 class="m-0 font-weight-bold text-danger">Stok Obat Hampir Habis</h6> --}}
        </div>
        <div class="card-body">
            <ul>
                <!-- ✅ Looping data stok obat yang hampir habis -->
                @foreach ($stokHampirHabis as $obat)
                <li>{{ $obat->nama_obat }} - Sisa: {{ $obat->jmlh_stok }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
