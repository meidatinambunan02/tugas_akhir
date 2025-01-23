@extends('sbadmin2.sbadmin')

@section('title')
Tambah Data COA
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data COA</h1>

    <!-- Button to Open Modal -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCOAModal">
        Tambah Data
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addCOAModal" tabindex="-1" role="dialog" aria-labelledby="addCOAModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCOAModalLabel">Tambah Data COA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Tambah COA -->
                    <form action="{{ route('coa.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="kode_coa">Kode COA</label>
                            <input type="text" class="form-control" id="kode_coa" name="kode_coa" placeholder="Masukkan Kode COA" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_akun">Nama Akun</label>
                            <input type="text" class="form-control" id="nama_akun" name="nama_akun" placeholder="Masukkan Nama Akun" required>
                        </div>
                        <div class="form-group">
                            <label for="header_akun">Header Akun</label>
                            <input type="text" class="form-control" id="header_akun" name="header_akun" placeholder="Masukkan Header Akun" required>
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
