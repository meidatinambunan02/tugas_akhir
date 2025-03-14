@extends('sbadmin2.sbadmin')

@section('title', 'Laporan Laba Rugi')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan Laba Rugi</h1>

    <!-- Filter Periode -->
    <form action="{{ route('laporan.laba-rugi') }}" method="GET">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporan.laba-rugi.export', request()->all()) }}" class="btn btn-success">
                    Export PDF
                </a>
            </div>
        </div>
    </form>

    <!-- Tabel Pendapatan -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="mb-3">Pendapatan</h4>
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Jurnal</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendapatan as $item)
                        <tr>
                            <td>{{ $item->no_jurnal }}</td>
                            <td>{{ $item->tgl_jurnal }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td class="text-end">{{ number_format($item->kredit, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-end">Total Pendapatan</th>
                        <th class="text-end">{{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Beban -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h4 class="mb-3">Beban</h4>
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No Jurnal</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th class="text-end">Debit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beban as $item)
                        <tr>
                            <td>{{ $item->no_jurnal }}</td>
                            <td>{{ $item->tgl_jurnal }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td class="text-end">{{ number_format($item->debit, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-end">Total Beban</th>
                        <th class="text-end">{{ number_format($totalBeban, 0, ',', '.') }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Laba Bersih -->
    <div class="card shadow">
        <div class="card-body">
            <h4 class="text-end">
                Laba Bersih: <strong>{{ number_format($labaBersih, 0, ',', '.') }}</strong>
            </h4>
        </div>
    </div>
</div>
@endsection
