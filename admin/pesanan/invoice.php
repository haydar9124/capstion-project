<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

// Mengamankan parameter ID menggunakan real_escape_string
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

$pesanan=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id_user
WHERE pesanan.id_pesanan='$id'
LIMIT 1
"));

if (!$pesanan) {
    die("Pesanan tidak ditemukan.");
}

$detail = mysqli_query($conn, "
    SELECT
        detail_pesanan.*,
        produk.nama_produk
    FROM detail_pesanan
    JOIN produk
    ON detail_pesanan.id_produk=produk.id_produk
    WHERE detail_pesanan.id_pesanan='$id'
");

$pembayaran=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM metode_pembayaran
WHERE nama_metode='".$pesanan['metode_pembayaran']."'
LIMIT 1
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - E-Warung</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #eee;
            padding: 15px;
        }

        .invoice-wrapper {
            max-width: 500px;
            margin: auto;
        }

        .invoice {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,.05);
        }

        h1 {
            color: #ef4b2f;
            margin-bottom: 3px;
            font-size: 20px;
        }

        .subtitle {
            font-size: 11px;
            color: #666;
        }

        hr {
            margin: 12px 0;
            border: 0;
            border-top: 1px dashed #ddd;
        }

        .info-pembelian p {
            font-size: 12px;
            margin-bottom: 5px;
            color: #333;
            display: flex;
            justify-content: space-between;
        }

        .info-pembelian p b {
            color: #666;
            font-weight: 400;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-top: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        table th {
            background: #f8f9fa;
            color: #333;
            text-align: left;
            padding: 8px;
            border-bottom: 2px solid #ef4b2f;
        }

        table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .total {
            margin-top: 15px;
            text-align: right;
        }

        .total h2 {
            font-size: 16px;
            color: #ef4b2f;
        }

        .action-buttons {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            padding: 11px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            text-align: center;
            text-decoration: none;
            display: block;
            width: 100%;
        }

        .btn-print {
            background: #ef4b2f;
            color: white;
        }

        .btn-home {
            background: #fff;
            color: #333;
            border: 1px solid #ccc;
        }

        @media(min-width: 576px) {
            body {
                padding: 30px;
            }
            .invoice {
                padding: 30px;
            }
            .action-buttons {
                flex-direction: row;
                justify-content: flex-end;
            }
            .btn {
                width: auto;
            }
        }

        @media print {
            .action-buttons {
                display: none !important;
            }
            body {
                background: white;
                padding: 0;
            }
            .invoice {
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="invoice-wrapper">

    <div class="invoice" id="invoiceArea">

        <h1>E-Warung</h1>
        <p class="subtitle">Invoice Pembelian Resmi</p>
        
        <hr>

        <div class="info-pembelian">
            <p><b>No Invoice:</b> <span>INV<?= str_pad($pesanan['id_pesanan'], 6, "0", STR_PAD_LEFT); ?></span></p>
            <p><b>Tanggal:</b> <span><?= date("d-m-Y H:i", strtotime($pesanan['tanggal'])); ?></span></p>
            <p><b>Nama Pelanggan:</b> <span><?= htmlspecialchars($pesanan['nama']); ?></span></p>
            <p><b>Metode Bayar:</b> <span><?= htmlspecialchars($pesanan['metode_pembayaran']); ?></span></p>
            
            <div style="margin-top: 10px; padding-top: 8px; border-top: 1px dashed #eee;">
                <b style="font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 3px;">Alamat Pengiriman:</b>
                <span style="color: #333; font-size: 12px; display: block; line-height: 1.5; background: #f9f9f9; padding: 8px; border-radius: 6px;">
                    <?= nl2br(htmlspecialchars($pesanan['alamat'])); ?>
                </span>
            </div>
        </div>

        <hr>

<?php if($pesanan['metode_pembayaran']=="COD"){ ?>

<hr>

<div style="background:#e8f5e9;padding:15px;border-radius:10px;margin-bottom:20px;">

<h3 style="color:#2e7d32;">

<i class="fa-solid fa-truck"></i>

Pembayaran COD

</h3>

<p style="margin-top:10px;">

Silakan lakukan pembayaran kepada kurir saat pesanan diterima.

</p>

</div>

<?php }else{ ?>

<hr>

<div style="background:#fff7ed;padding:15px;border-radius:10px;margin-bottom:20px;border:1px solid #fed7aa;">

<h3 style="color:#ef4b2f;">

<i class="fa-solid fa-building-columns"></i>

Informasi Pembayaran

</h3>

<br>

<p>

<b>Metode :</b>

<?= $pembayaran['nama_metode']; ?>

</p>

<br>

<p>

<b>Nomor Rekening / E-Wallet</b>

</p>

<h3>

<?= $pembayaran['nomor']; ?>

</h3>

<br>

<p>

<b>Atas Nama</b>

</p>

<h3>

<?= $pembayaran['atas_nama']; ?>

</h3>

<?php if($pembayaran['gambar']!=""){ ?>

<br>

<center>

<img
src="../../uploads/pembayaran/<?= $pembayaran['gambar']; ?>"
style="
width:220px;
border-radius:12px;
box-shadow:0 2px 10px rgba(0,0,0,.1);
">

</center>

<?php } ?>

</div>

<?php } ?>        
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($detail)){ ?>
                    <tr>
                        <td>
                            <span style="font-weight: 600; color: #222;"><?= htmlspecialchars($row['nama_produk']); ?></span>
                            <br>
                            <span style="font-size: 10px; color: #888;">@Rp <?= number_format($row['harga']); ?></span>
                        </td>
                        <td style="text-align: center; color: #666;">
                            <?= $row['qty']; ?>
                        </td>
                        <td style="text-align: right; font-weight: 600;">
                            Rp <?= number_format($row['subtotal']); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <h2>Total : Rp <?= number_format($pesanan['total']); ?></h2>
        </div>

    </div>

    <div class="action-buttons">
        <a href="index.php" class="btn btn-home">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
        <button onclick="unduhAtauCetak()" class="btn btn-print">
            <i class="fa-solid fa-download"></i> Simpan / Cetak Invoice
        </button>
    </div>

</div>

<script>
function unduhAtauCetak() {
    const element = document.getElementById('invoiceArea');
    const noInvoice = "INV<?= str_pad($pesanan['id_pesanan'], 6, "0", STR_PAD_LEFT); ?>";
    
    const opsi = {
        margin:       10,
        filename:     'Invoice_' + noInvoice + '.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opsi).from(element).save();
}
</script>

</body>
</html>