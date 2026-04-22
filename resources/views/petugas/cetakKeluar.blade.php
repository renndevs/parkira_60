<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Struk Pembayaran - Parkira</title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            color: #000;
        }

        .center {
            text-align: center;
        }

        .garis {
            border-bottom: 2px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
        }

        td {
            padding: 2px 0;
            font-size: 14px;
        }

        .right {
            text-align: right;
        }

        .btn-kembali {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-family: sans-serif;
            font-weight: bold;
        }

        /* Saat struk diprint, tombol kembali akan menghilang otomatis */
        @media print {
            .btn-kembali {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="center">
        <h2 style="margin-bottom: 0;">PARKIRA</h2>
        <p style="margin-top: 5px;">SMKN 4 TANGERANG</p>
        <p>STRUK PEMBAYARAN</p>
    </div>

    <div class="garis"></div>
    <p>Petugas : {{ Auth::user()->nama_lengkap ?? 'Kasir' }}</p>
    <p>Waktu : {{ date('d M Y H:i') }}</p>
    <div class="garis"></div>

    <h2 class="center" style="font-size: 24px; margin: 10px 0;">{{ $transaksi->kendaraan->plat_nomor }}</h2>

    <table>
        <tr>
            <td>Masuk</td>
            <td class="right">{{ date('H:i', strtotime($transaksi->waktu_masuk)) }}</td>
        </tr>
        <tr>
            <td>Keluar</td>
            <td class="right">{{ date('H:i', strtotime($transaksi->waktu_keluar)) }}</td>
        </tr>
        <tr>
            <td>Durasi</td>
            <td class="right">{{ $transaksi->durasi_jam }} Jam</td>
        </tr>
        <tr>
            <td>Tarif/Jam</td>
            <td class="right">Rp {{ number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="garis"></div>

    <table>
        <tr>
            <td><strong>TOTAL</strong></td>
            <td class="right"><strong>Rp {{ number_format($transaksi->biaya_total, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>TUNAI</td>
            <td class="right">Rp {{ number_format($uang_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>KEMBALI</td>
            <td class="right">Rp {{ number_format($kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="garis"></div>
    <p class="center">Terima Kasih<br>Selamat Jalan</p>

    <a href="/transaksi" class="btn-kembali">Kembali ke Transaksi</a>
</body>

</html>
