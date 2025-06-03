<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Rugi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-weight: bold;
            margin: 10px 0 5px 0;
            font-size: 16px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }
        .total-row {
            font-weight: bold;
            border-top: 1px solid #000;
            margin-top: 5px;
            padding-top: 5px;
        }
        .laba-bersih {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        .divider {
            height: 1px;
            background-color: #000;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Apotek Milan</h1>
        <h2>Laporan Laba Rugi</h2>
        <p>Periode: {{ $start_date ?? $startDate }} - {{ $end_date ?? $endDate }}</p>
    </div>

    <div class="section">
        <div class="section-title">Pendapatan</div>
        @foreach ($pendapatan as $item)
        <div class="row">
            <div>{{ $item->coa->nama_akun }}</div>
            <div>{{ number_format($item->kredit, 0, ',', '.') }}</div>
        </div>
        @endforeach
        <div class="row total-row">
            <div>Total Pendapatan</div>
            <div>{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="section">
        <div class="section-title">Beban</div>
        @foreach ($beban as $item)
        <div class="row">
            <div>{{ $item->coa->nama_akun }}</div>
            <div>{{ number_format($item->debit, 0, ',', '.') }}</div>
        </div>
        @endforeach
        <div class="row total-row">
            <div>Total Beban</div>
            <div>{{ number_format($totalBeban, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="row laba-bersih">
        <div>Laba Bersih</div>
        <div>{{ number_format($labaBersih, 0, ',', '.') }}</div>
    </div>
</body>
</html>