<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            background-color: #f0f0f0;
        }
        .struk {
            background-color: #fff;
            width: 80mm; /* Ukuran kertas struk kasir standar */
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .center {
            text-align: center;
        }
        .bold {
            font-weight: bold;
        }
        .garis {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
        }
        p {
            margin: 5px 0;
            font-size: 14px;
        }
        /* Mode cetak agar background abu-abu tidak ikut terprint */
        @media print {
            body {
                background-color: transparent;
                padding: 0;
            }
            .struk {
                box-shadow: none;
            }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis memicu kotak dialog Print/PDF -->
    <div class="struk">
        <div class="center bold">
            <p>LAUNDRY BAYU</p>
            <p style="font-size: 12px; font-weight: normal;">Jl. Bersih Selalu No. 1, Bekasi</p>
        </div>
        
        <div class="garis"></div>
        
        <p>No. Transaksi : #{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p>Tanggal       : {{ $transaksi->created_at->format('d M Y H:i') }}</p>
        <p>Pelanggan     : {{ $transaksi->nama_pelanggan }}</p>
        <p>Status        : {{ $transaksi->status_pembayaran }}</p>
        
        <div class="garis"></div>
        
        <p class="bold">Detail Layanan:</p>
        <p>{{ $transaksi->jenis_layanan }}</p>
        <div class="flex-between">
            <p>Berat/Jml: {{ $transaksi->berat_atau_jumlah }}</p>
            <p>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        </div>
        
        <!-- Fitur Baru: Metode Pembayaran -->
        <p>Metode Bayar  : {{ $transaksi->metode_pembayaran ?? '-' }}</p>
        
        <div class="garis"></div>
        
        <div class="flex-between bold">
            <p>TOTAL BAYAR</p>
            <p>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
        </div>
        
        <div class="garis"></div>
        
        <div class="center">
            <p>Terima Kasih</p>
            <p style="font-size: 12px;">Pakaian Bersih, Hati Senang</p>
        </div>
    </div>
</body>
</html>