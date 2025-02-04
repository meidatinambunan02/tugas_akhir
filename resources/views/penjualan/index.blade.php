@extends('sbadmin2.sbadmin')

@section('title')
    Daftar Transaksi Penjualan Apotek Milan
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Transaksi Penjualan Apotek Milan</h1>

        <!-- Tabel Penjualan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Penjualan</h6>
                </br>

                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Jual</th>
                                <th>Nomor Transaksi</th>
                                <th>Tanggal Jual</th>
                                <th>Nama Obat</th>
                                <th>Jumlah Obat</th>
                                <th>Harga Satuan</th>
                                <th>Total Jual</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Data Baris 1 -->
                            @foreach ($datapenjualan as $penjualan)
                                <tr>
                                    <td>{{ $penjualan->id_jual }}</td>
                                    <td>{{ $penjualan->no_trans }}</td>
                                    <td>{{ $penjualan->tgl_jual }}</td>
                                    <td>{{ $penjualan->nama_obat }}</td>
                                    <td>{{ $penjualan->jmlh_jual }}</td>
                                    <td>{{ $penjualan->harga_satuan }}</td>
                                    <td>{{ $penjualan->total_jual }}</td>
                                    <td>
                                        <!-- Add action buttons here (e.g., Edit, Delete) -->
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $penjualan->id }}">Edit</a>
                                        <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Tombol untuk memunculkan modal konfirmasi -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal{{ $penjualan->id }}">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Tabel Penjualan -->
    </div>
     <!-- Modal Tambah Penjualan -->
     <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Transaksi Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="id_jual">ID Jual</label>
                            <input type="number" class="form-control" id="id_jual" name="id_jual" required>
                        </div>
                        <div class="form-group">
                            <label for="no_trans">Nomor Transaksi</label>
                            <input type="number" class="form-control" id="no_trans" name="no_trans" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_jual">Tanggal Jual</label>
                            <input type="date" class="form-control" id="tgl_jual" name="tgl_jual" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_obat">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                        </div>
                        <div class="form-group">
                            <label for="jmlh_jual">Jumlah Obat</label>
                            <input type="number" class="form-control" id="jmlh_jual" name="jmlh_jual" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan</label>
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" required>
                        </div>
                        <div class="form-group">
                            <label for="total_jual">Total Jual</label>
                            <input type="number" class="form-control" id="total_jual" name="total_jual" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @endsection
   

