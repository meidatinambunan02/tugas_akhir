@extends('sbadmin2.sbadmin')

@section('title')
List Pelanggan
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">List Pelanggan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pelanggan</h6>
            <br>
            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahModal">Tambah Data</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode Pelanggan</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
              
            </table>
        </div>
    </div>
</div>

@endsection
