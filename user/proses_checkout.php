<?php
// 1. PAKSA PHP UNTUK MENAMPILKAN ERROR JIKA ADA CRASH
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. CEK SEBELUM MEMULAI SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. HUBUNGKAN KE DATABASE
include '../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

// Pastikan data user ada di session, jika tidak ada paksa login
if (!isset($_SESSION['id_user'])) {
    echo "
    <script>
    alert('Sesi Anda telah habis atau Anda belum login. Silakan login kembali.');
    window.location='login.php';
    </script>
    ";
    exit;
}

$id_user = $_SESSION['id_user'];
$alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';
$id_metode = isset($_POST['metode']) ? (int)$_POST['metode'] : 0;

$qMetode=mysqli_query($conn,"
SELECT *
FROM metode_pembayaran
WHERE id_metode='$id_metode'
LIMIT 1
");

if(mysqli_num_rows($qMetode)==0){

echo "

<script>

alert('Metode pembayaran tidak ditemukan.');

history.back();

</script>

";

exit;

}

$dataMetode=mysqli_fetch_assoc($qMetode);

$metode=$dataMetode['nama_metode'];

$status="Menunggu Pembayaran";
// Validasi jika input alamat kosong
if (empty($alamat) || empty($metode)) {
    echo "
    <script>
    alert('Alamat dan Metode Pembayaran wajib diisi!');
    history.back();
    </script>
    ";
    exit;
}

// 4. CEK ISI KERANJANG
$cekKeranjang = mysqli_query($conn, "
    SELECT 
        keranjang.*, 
        produk.nama_produk, 
        produk.harga, 
        produk.stok 
    FROM keranjang 
    JOIN produk 
    ON keranjang.id_produk=produk.id_produk 
    WHERE keranjang.id_user='$id_user'
");

if (!$cekKeranjang) {
    die("Error Gagal Cek Keranjang: " . mysqli_error($conn));
}

if (mysqli_num_rows($cekKeranjang) == 0) {
    echo "
    <script>
    alert('Keranjang belanja Anda kosong.');
    window.location='checkout.php';
    </script>
    ";
    exit;
}

$total = 0;
$items = [];

// Validasi stok barang
while ($row = mysqli_fetch_assoc($cekKeranjang)) {
    if ($row['qty'] > $row['stok']) {
        echo "
        <script>
        alert('Stok barang " . addslashes($row['nama_produk']) . " tidak mencukupi.');
        window.location='checkout.php';
        </script>
        ";
        exit;
    }
    $total += ($row['harga'] * $row['qty']);
    $items[] = $row;
}

// 5. INSERT DATA KE TABEL PESANAN
$query_pesanan = mysqli_query($conn, "
    INSERT INTO pesanan (
        id_user, 
        alamat,
        metode_pembayaran, 
        total, 
        status, 
        tanggal
    ) VALUES (
        '$id_user', 
        '$alamat',
        '$metode', 
        '$total', 
        '$status', 
        NOW()
    )
");

if (!$query_pesanan) {
    die("Error Gagal Input Tabel Pesanan: " . mysqli_error($conn));
}

// Ambil ID Pesanan baru
$id_pesanan = mysqli_insert_id($conn);

// 6. INSERT DATA KE DETAIL PESANAN & POTONG STOK
foreach ($items as $item) {
    $subtotal = $item['harga'] * $item['qty'];
    $id_produk = $item['id_produk'];
    $qty = $item['qty'];
    $harga = $item['harga'];

    $query_detail = mysqli_query($conn, "
        INSERT INTO detail_pesanan (
            id_pesanan, 
            id_produk, 
            qty, 
            harga, 
            subtotal
        ) VALUES (
            '$id_pesanan', 
            '$id_produk', 
            '$qty', 
            '$harga', 
            '$subtotal'
        )
    ");
    
    if (!$query_detail) {
        die("Error Gagal Input Detail Pesanan: " . mysqli_error($conn));
    }

    // Jalankan pemotongan stok produk
    mysqli_query($conn, "
        UPDATE produk 
        SET stok = stok - $qty 
        WHERE id_produk = '$id_produk'
    ");
}

// 7. BERSIHKAN KERANJANG
mysqli_query($conn, "
    DELETE FROM keranjang 
    WHERE id_user='$id_user'
");

// 8. TAMPILKAN HALAMAN SUKSES DAN PILIHAN AKSI
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .success-card {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .icon {
            font-size: 60px;
            color: #2ecc71;
            margin-bottom: 20px;
        }
        h2 {
            margin: 0 0 10px 0;
            color: #333;
        }
        p {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .btn {
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            display: block;
        }
        .btn-invoice {
            background: #ef4b2f;
            color: white;
            border: none;
        }
        .btn-invoice:hover {
            background: #d63f26;
        }
        .btn-home {
            background: #fff;
            color: #333;
            border: 1px solid #ccc;
        }
        .btn-home:hover {
            background: #f9f9f9;
        }
    </style>
</head>
<body>

<div class="success-card">
    <div class="icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <h2>Pesanan Berhasil!</h2>
    <p>Pesanan Anda telah sukses dibuat dan dicatat ke dalam sistem kami.</p>
    
    <div class="btn-group">
        <a href="invoice.php?id=<?= $id_pesanan; ?>" class="btn btn-invoice">
            <i class="fa-solid fa-print"></i> Lihat / Cetak Invoice
        </a>
        <a href="dashboard.php" class="btn btn-home">
            <i class="fa-solid fa-store"></i> Belanja Barang Lainnya
        </a>
    </div>
</div>

</body>
</html>
<?php exit; ?>