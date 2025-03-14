<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2>Laporan Penjualan</h2>
<p>Periode: {{ $startDate }} - {{ $endDate }}</p>

<table>
    <thead>
        <tr>
            <th>No Transaksi</th>
            <th>Tanggal Jual</th>
            <th>Pelanggan</th>
            <th>Obat</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($riwayat as $transaksi)
            @foreach ($transaksi->detailPenjualan as $detail)
                <tr>
                    <td>{{ $transaksi->no_trans }}</td>
                    <td>{{ $transaksi->tgl_jual }}</td>
                    <td>{{ optional($transaksi->pelanggan)->nama_pelanggan ?? '-' }}</td>
                    <td>{{ optional($detail->obat)->nama_obat ?? '-' }}</td>
                    <td>{{ $detail->jmlh_jual }}</td>
                    <td>{{ $detail->harga_satuan }}</td>
                    <td>{{ number_format($detail->total_jual, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

</body>
</html>
