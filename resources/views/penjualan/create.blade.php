@extends('sbadmin2.sbadmin')

@section('title')
    Tambah Transaksi Penjualan
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Transaksi Penjualan</h1>

        <!-- Button to Open Modal -->
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPenjualanModal">
            Tambah Transaksi
        </button>

        <!-- Modal -->
        <div class="modal fade" id="addPenjualanModal" tabindex="-1" role="dialog" aria-labelledby="addPenjualanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPenjualanModalLabel">Tambah Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Tambah Transaksi Penjualan -->
                        <form action="{{ route('penjualan.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="id_jual">ID Jual</label>
                                <input type="text" class="form-control" id="id_jual" name="id_jual"
                                    placeholder="Masukkan ID Jual" required>
                            </div>
                            <div class="form-group">
                                <label for="no_trans">Nomor Transaksi </label>
                                <input type="text" class="form-control" id="no_trans" name="no_trans"
                                    placeholder="Masukkan Nomor Transaksi" required>
                            </div>
                            <div class="form-group">
                                <label for="no_trans">Tanggal Jual </label>
                                <input type="date" class="form-control" id="tgl_jual" name="tgl_jual"
                                    placeholder="Masukkan Tanggal Jual" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_obat">Nama Obat</label>
                                <input type="text" class="form-control" id="nama_obat" name="nama_obat"
                                    placeholder="Masukkan Nama Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="jmlh_jual">Jumlah Obat</label>
                                <input type="text" class="form-control" id="jmlh_jual" name="jmlh_jual"
                                    placeholder="Masukkan Jumlah Obat" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="text" class="form-control" id="harga_satuan" name="harga_satuan"
                                    placeholder="Masukkan Harga Satuan" required>
                            </div>
                            <div class="form-group">
                                <label for="total_jual">Total Jual</label>
                                <input type="text" class="form-control" id="total_jual" name="total_jual"
                                    placeholder="Masukkan Total" required>

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
