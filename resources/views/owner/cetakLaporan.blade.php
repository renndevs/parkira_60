<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Parkira</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        table th,
        table td {
            border: 1px solid #333;
            padding: 8px;
        }

        table th {
            background-color: #f4f4f4;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Area Tanda Tangan */
        .ttd-container {
            width: 100%;
            margin-top: 40px;
        }

        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .ttd-box p {
            margin: 5px 0;
        }

        .ttd-space {
            height: 80px;
        }

        /* Tombol Kembali */
        .btn-kembali {
            display: block;
            text-align: center;
            margin-top: 60px;
            padding: 12px 24px;
            background: #1E293B;
            /* Warna dark blue senada dengan sidebar owner */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-family: sans-serif;
            font-weight: bold;
            width: max-content;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-kembali:hover {
            background: #0F172A;
        }

        /* Mode Print: Sembunyikan Tombol */
        @media print {
            .btn-kembali {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h1>Laporan Pendapatan Parkir - PARKIRA</h1>
        <p>SMKN 4 TANGERANG</p>
        @if ($tgl_awal && $tgl_akhir)
            <p>Periode: {{ date('d F Y', strtotime($tgl_awal)) }} s/d {{ date('d F Y', strtotime($tgl_akhir)) }}</p>
        @else
            <p>Periode: Semua Waktu</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Plat Nomor</th>
                <th>Jenis Kendaraan</th>
                <th>Waktu Keluar</th>
                <th class="text-right">Biaya Parkir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporans as $index => $l)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="text-transform: uppercase;">{{ $l->kendaraan->plat_nomor }}</td>
                    <td>{{ $l->kendaraan->jenis_kendaraan }}</td>
                    <td>{{ date('d-m-Y H:i', strtotime($l->waktu_keluar)) }}</td>
                    <td class="text-right">Rp {{ number_format($l->biaya_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTAL PENDAPATAN</th>
                <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Tangerang, {{ date('d F Y') }}</p>
            <p>Mengetahui,</p>
            <div class="ttd-space"></div>
            <p><strong><u>Pimpinan / Owner</u></strong></p>
        </div>
    </div>

    <div style="clear: both;"></div>

    <a href="/owner/laporan" class="btn-kembali">← Kembali ke Laporan</a>

</body>

</html>
