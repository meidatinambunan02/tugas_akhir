@extends('sbadmin2.sbadmin')

@section('title')
    Tambah Data Obat
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Data Obat</h1>

        <!-- Button to Open Modal -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addObatModal">
            Tambah Data
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addObatModal" tabindex="-1" role="dialog" aria-labelledby="addObatModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addObatModalLabel">Tambah Data Obat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Tambah Obat -->
                        <form action="{{ route('obat.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="kode_obat">Kode Obat</label>
                                <input type="text" class="form-control" id="kode_obat" name="kode_obat"
                                    placeholder="Masukkan Kode Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_obat">Nama Obat</label>
                                <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                                    placeholder="Masukkan Nama Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="jmlh_stok">Jumlah Stok Obat</label>
                                <input type="text" class="form-control" id="jmlh_stok" name="jmlh_stok"
                                    placeholder="Masukkan Jumlah Stok Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga Obat</label>
                                <input type="text" class="form-control" id="harga" name="harga"
                                    placeholder="Masukkan Harga Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_beli">Tanggal Beli</label>
                                <input type="date" class="form-control" id="tgl_beli" name="tgl_beli"
                                    placeholder="Masukkan Tanggal Beli" required>

                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </div>
@endsection

@section('script')
    <!-- Modal Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
