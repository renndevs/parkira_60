<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Tiket Parkir</title>
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

        .btn-kembali {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
        }

        @media print {
            .btn-kembali {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="center">
        <h2>PARKIRA</h2>
        <p>SMKN 4 TANGERANG</p>
    </div>
    <div class="garis"></div>
    <p>TIKET MASUK PARKIR</p>
    <p>No. Transaksi: #{{ $transaksi->id_parkir }}</p>
    <p>Waktu Masuk : {{ date('d M Y H:i', strtotime($transaksi->waktu_masuk)) }}</p>
    <div class="garis"></div>
    <h1 class="center">{{ $transaksi->kendaraan->plat_nomor }}</h1>
    <h3 class="center">{{ $transaksi->areaParkir->nama_area }}</h3>
    <div class="garis"></div>
    <p class="center" style="font-size: 12px;">Simpan tiket ini baik-baik.<br>Jangan tinggalkan barang berharga di
        kendaraan.</p>

    <a href="/transaksi" class="btn-kembali">Kembali ke Transaksi</a>
</body>

</html>
