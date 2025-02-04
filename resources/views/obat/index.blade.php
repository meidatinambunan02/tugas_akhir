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

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('obat.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kode_obat">Kode Obat</label>
                            <input type="number" class="form-control" id="kode_obat" name="kode_obat" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_obat">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                        </div>
                        <div class="form-group">
                            <label for="jmlh_stok">Jumlah Stok</label>
                            <input type="number" class="form-control" id="jmlh_stok" name="jmlh_stok" required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tanggal Beli</label>
                            <input type="date" class="form-control" id="tgl_beli" name="tgl_beli" required>
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

    @foreach ($dataobat as $obat)
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $obat->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $obat->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $obat->id }}">Edit Data Obat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kode_obat">Kode Obat</label>
                                <input type="text" class="form-control" id="kode_obat" name="kode_obat"
                                    value="{{ $obat->kode_obat }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_obat">Nama Obat</label>
                                <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                                    value="{{ $obat->nama_obat }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jmlh_stok">Jumlah Stok Obat</label>
                                <input type="text" class="form-control" id="jmlh_stok" name="jmlh_stok"
                                    value="{{ $obat->jmlh_stok }}" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga Obat</label>
                                <input type="text" class="form-control" id="harga" name="harga"
                                    value="{{ $obat->harga }}" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_beli">Tanggal Beli</label>
                                <input type="date" class="form-control" id="tgl_beli" name="tgl_beli"
                                    value="{{ $obat->tgl_beli }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @foreach ($dataobat as $obat)
        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal{{ $obat->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $obat->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $obat->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data <strong>{{ $obat->nama_obat }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('obat.destroy', $obat->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

@endsection
