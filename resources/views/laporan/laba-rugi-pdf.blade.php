<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
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

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .text-end {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
            font-size: 14px;
        }

        h2,
        h4 {
            margin: 0;
            padding: 5px 0;
        }

    </style>
</head>
<body>

    <h2>Laporan Laba Rugi</h2>
    <p>Periode: {{ $startDate }} - {{ $endDate }}</p>

    {{-- Tabel Pendapatan --}}
    <h4>Pendapatan</h4>
    <table>
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

    {{-- Tabel Beban --}}
    <h4>Beban</h4>
    <table>
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

    {{-- Laba Bersih --}}
    <div class="summary">
        <h4 class="text-end">
            Laba Bersih: {{ number_format($labaBersih, 0, ',', '.') }}
        </h4>
    </div>

</body>
</html>
