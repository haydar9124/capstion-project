<?php

include '../config/session_admin.php';
include '../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Dashboard Admin";
$back_url="#";

include '../layout/header_admin.php';
include '../layout/page_header_admin.php';

/* ===========================
CARD
=========================== */

$totalProduk=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM produk
"));

$totalUser=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='user'
"));

$totalPesanan=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM pesanan
"));

$omzetHari=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE DATE(tanggal)=CURDATE()
AND status='Selesai'
"));

$stokMenipis=mysqli_query($conn,"
SELECT *
FROM produk
WHERE stok<=10
ORDER BY stok ASC
LIMIT 5
");

$produkTerlaris=mysqli_query($conn,"
SELECT
produk.nama_produk,
SUM(detail_pesanan.qty) total_jual
FROM detail_pesanan
JOIN produk
ON detail_pesanan.id_produk=produk.id_produk
GROUP BY detail_pesanan.id_produk
ORDER BY total_jual DESC
LIMIT 5
");

$pesananTerbaru=mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id_user
ORDER BY tanggal DESC
LIMIT 5
");

/* ======================
GRAFIK 7 HARI
====================== */

$label=[];

$data=[];

for($i=6;$i>=0;$i--){

$tanggal=date("Y-m-d",strtotime("-".$i." day"));

$label[]=date("d/m",strtotime($tanggal));

$q=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT
IFNULL(SUM(total),0) total
FROM pesanan
WHERE DATE(tanggal)='$tanggal'
AND status='Selesai'
"));

$data[]=$q['total'];

}

?>

<div class="page-content">

<div class="card" style="text-align:center;">

<h2>

Selamat Datang,

<?= $_SESSION['nama']; ?>

</h2>

<p>

Administrator E-Warung

</p>

</div>

<div class="card">

<h3>Total Produk</h3>

<h1 style="color:#ef4b2f;">

<?= $totalProduk['total']; ?>

</h1>

</div>

<div class="card">

<h3>Total User</h3>

<h1 style="color:#ef4b2f;">

<?= $totalUser['total']; ?>

</h1>

</div>

<div class="card">

<h3>Total Pesanan</h3>

<h1 style="color:#ef4b2f;">

<?= $totalPesanan['total']; ?>

</h1>

</div>

<div class="card">

<h3>Omzet Hari Ini</h3>

<h2 style="color:green;">

Rp <?= number_format($omzetHari['total']); ?>

</h2>

</div>

<div class="card">

<h3>Grafik Penjualan 7 Hari</h3>

<canvas id="grafikPenjualan"></canvas>

</div>

<div class="card">

<h3>

Produk Terlaris

</h3>

<?php while($row=mysqli_fetch_assoc($produkTerlaris)){ ?>

<div style="padding:10px 0;border-bottom:1px solid #ddd;">

<b>

<?= $row['nama_produk']; ?>

</b>

<br>

Terjual

<?= $row['total_jual']; ?>

kali

</div>

<?php } ?>

</div>

<div class="card">

<h3>

Stok Menipis

</h3>

<?php

if(mysqli_num_rows($stokMenipis)==0){

echo "Semua stok aman.";

}

while($row=mysqli_fetch_assoc($stokMenipis)){

?>

<div style="padding:10px 0;border-bottom:1px solid #ddd;">

<?= $row['nama_produk']; ?>

<br>

<b style="color:red;">

Stok :

<?= $row['stok']; ?>

</b>

</div>

<?php } ?>

</div>

<div class="card">

<h3>

Pesanan Terbaru

</h3>

<?php while($row=mysqli_fetch_assoc($pesananTerbaru)){ ?>

<div style="padding:10px 0;border-bottom:1px solid #ddd;">

<b>

<?= $row['nama']; ?>

</b>

<br>

Rp <?= number_format($row['total']); ?>

<br>

<?= $row['status']; ?>

</div>

<?php } ?>

</div>

<a
href="produk/index.php"
class="btn-primary">

<i class="fa-solid fa-box"></i>

Kelola Produk

</a>

<br>

<a
href="pesanan/index.php"
class="btn-warning">

<i class="fa-solid fa-cart-shopping"></i>

Kelola Pesanan

</a>

<br>

<a
href="laporan/index.php"
class="btn-success">

<i class="fa-solid fa-chart-column"></i>

Laporan Penjualan

</a>

<br>

<a
href="pembayaran/index.php"
class="btn-primary">

<i class="fa-solid fa-money-check-dollar"></i>

Kelola Pembayaran

</a>

<br>

<a
href="profil.php"
class="btn-success">

<i class="fa-solid fa-user"></i>

Profil Admin

</a>

<br>

<a
href="../auth/logout.php"
class="btn-danger"
onclick="return confirm('Yakin ingin logout?')">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>

</div>

</div>

<script>

const ctx=document.getElementById('grafikPenjualan');

new Chart(ctx,{

type:'line',

data:{

labels:[
<?= "'".implode("','",$label)."'" ?>
],

datasets:[{

label:'Omzet',

data:[
<?= implode(",",$data); ?>
],

fill:false,

borderWidth:3,

tension:0.3

}]

},

options:{

responsive:true

}

});

</script>

</body>
</html>