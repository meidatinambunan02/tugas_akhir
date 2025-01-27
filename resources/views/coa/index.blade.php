@extends('sbadmin2.sbadmin')

@section('title')
    List COA
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">List COA</h1>

        <!-- Tabel COA -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Chart of Accounts (COA)</h6>
                </br>

                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah Data</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kode COA</th>
                                <th>Nama Akun</th>
                                <th>Header Akun</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Data Baris 1 -->
                            @foreach ($datacoa as $coa)
                                <tr>
                                    <td>{{ $coa->kode_coa }}</td>
                                    <td>{{ $coa->nama_akun }}</td>
                                    <td>{{ $coa->header_akun }}</td>
                                    <td>
                                        <!-- Add action buttons here (e.g., Edit, Delete) -->
                                        <a href="#" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $coa->id }}">Edit</a>
                                            <form action="{{ route('coa.destroy', $coa->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <!-- Tombol untuk memunculkan modal konfirmasi -->
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $coa->id }}">Delete</button>
                                            </form>
                                            

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Tabel COA -->
    </div>

    <!-- Tombol Tambah Data -->


    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data COA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('coa.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_coa">Kode COA</label>
                            <input type="text" class="form-control" id="kode_coa" name="kode_coa" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_akun">Nama Akun</label>
                            <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                        </div>
                        <div class="form-group">
                            <label for="header_akun">Header Akun</label>
                            <input type="text" class="form-control" id="header_akun" name="header_akun" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($datacoa as $coa)
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $coa->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel{{ $coa->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $coa->id }}">Edit Data COA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('coa.update', $coa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kode_coa">Kode COA</label>
                                <input type="text" class="form-control" id="kode_coa" name="kode_coa"
                                    value="{{ $coa->kode_coa }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_akun">Nama Akun</label>
                                <input type="text" class="form-control" id="nama_akun" name="nama_akun"
                                    value="{{ $coa->nama_akun }}" required>
                            </div>
                            <div class="form-group">
                                <label for="header_akun">Header Akun</label>
                                <input type="text" class="form-control" id="header_akun" name="header_akun"
                                    value="{{ $coa->header_akun }}" required>
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


    @foreach ($datacoa as $coa)
        <!-- Modal Konfirmasi Hapus -->
        <div class="modal fade" id="deleteModal{{ $coa->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel{{ $coa->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $coa->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus data <strong>{{ $coa->nama_akun }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('coa.destroy', $coa->id) }}" method="POST">
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

@section('script')
    <!-- Kamu bisa menambahkan script tambahan di sini jika diperlukan -->
    <script src="https://cdn.jsdelivr.net/npm/datatables.net/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
