@extends('sbadmin2.sbadmin')

@section('title')
    List Obat
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">List Obat</h1>

        <!-- Tabel Obat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Obat</h6>
                </br>

                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode Obat</th>
                                <th>Nama Obat</th>
                                <th>Jumlah Stok</th>
                                <th>Harga</th>
                                <th>Tanggal Beli</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Data Baris 1 -->
                            @foreach ($dataobat as $obat)
                                <tr>
                                    <td>{{ $obat->kode_obat }}</td>
                                    <td>{{ $obat->nama_obat }}</td>
                                    <td>{{ $obat->jmlh_stok }}</td>
                                    <td>{{ $obat->harga }}</td>
                                    <td>{{ $obat->tgl_beli }}</td>
                                </tr>
                                    <td>
                                        <!-- Add action buttons here (e.g., Edit, Delete) -->
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $obat->id }}">Edit</a>
                                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Tombol untuk memunculkan modal konfirmasi -->
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteModal{{ $obat->id }}">Delete</button>
                                        </form>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Tabel Obat -->
    </div>

@endsection