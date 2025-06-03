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
<div class="text-center mb-4">
        <h5>Apotek Milan</h5>
        <strong>Laporan Laba Rugi</strong><br>
    </div>

    <!-- Pendapatan -->
    <div class="mb-3">
        <strong>Pendapatan</strong>
        <div class="d-flex justify-content-between">
            <span>Penjualan</span>
            <span>{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
        </div>
        <div class="d-flex justify-content-between fw-bold">
            <span>Total Pendapatan</span>
            <span>{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Beban -->
    <div class="mb-3">
        <strong>Beban</strong>
        @foreach ($beban as $item)
        <div class="d-flex justify-content-between">
            <span>{{ $item->deskripsi }}</span>
            <div class="col-5" number-align: right;>{{ number_format($item->debit, 0, ',', '.') }}</div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between fw-bold">
           <div class="col-7">Total Beban</div>
             <div class="col-5">{{ number_format($totalBeban, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Laba Bersih -->
    <div class="d-flex justify-content-between fw-bold border-top pt-2">
        <span>Laba Bersih</span>
        <span>{{ number_format($labaBersih, 0, ',', '.') }}</span>
    </div>
</div>
@endsection
