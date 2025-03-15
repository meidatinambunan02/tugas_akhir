@extends('sbadmin2.sbadmin')

@section('title')
Daftar Transaksi Lain
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Transaksi Lain</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Form Input Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi Lain</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi-lain.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="tgl_trans" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>COA</label>
                    <select name="coa_id" class="form-control" required>
                        @foreach ($coas as $coa)
                        <option value="{{ $coa->id }}">{{ $coa->kode_coa }} - {{ $coa->nama_akun }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>Total</label>
                    <input type="number" name="total" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <!-- End Form Input Transaksi -->

    <!-- Riwayat Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>COA</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $trx)
                        <tr>
                            <td>{{ $trx->no_trans }}</td>
                            <td>{{ $trx->tgl_trans }}</td>
                            <td>{{ $trx->coa->kode_coa }} - {{ $trx->coa->nama_akun }}</td>
                            <td>{{ $trx->keterangan ?? '-' }}</td>
                            <td>{{ number_format($trx->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Riwayat Transaksi -->


</div>
@endsection
