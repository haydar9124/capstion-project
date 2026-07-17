<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Laporan Mingguan";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

/* ==========================
   RANGE MINGGU INI
========================== */

$awal=date("Y-m-d",strtotime("monday this week"));
$akhir=date("Y-m-d",strtotime("sunday this week"));

/* ==========================
   OMZET
========================== */

$omzet=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE DATE(tanggal)
BETWEEN '$awal' AND '$akhir'
AND status='Selesai'
"));

/* ==========================
   TRANSAKSI
========================== */

$trx=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM pesanan
WHERE DATE(tanggal)
BETWEEN '$awal' AND '$akhir'
AND status='Selesai'
"));

/* ==========================
   PRODUK TERJUAL
========================== */

$produk=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(qty),0) total
FROM detail_pesanan
JOIN pesanan
ON detail_pesanan.id_pesanan=pesanan.id_pesanan
WHERE DATE(tanggal)
BETWEEN '$awal' AND '$akhir'
AND pesanan.status='Selesai'
"));

/* ==========================
   KEUNTUNGAN
========================== */

$keuntungan=$omzet['total']*20/100;

/* ==========================
   DATA
========================== */

$data=mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id_user
WHERE DATE(tanggal)
BETWEEN '$awal' AND '$akhir'
AND status='Selesai'
ORDER BY tanggal DESC
");

?>

<div class="page-content">

<div class="card">

<h2>

<i class="fa-solid fa-calendar-week"></i>

Laporan Mingguan

</h2>

<p>

<?= date("d M Y",strtotime($awal)); ?>

-

<?= date("d M Y",strtotime($akhir)); ?>

</p>

</div>

<div class="card">

<h3>Omzet Minggu Ini</h3>

<h1 style="color:green;">

Rp <?= number_format($omzet['total']); ?>

</h1>

</div>

<div class="card">

<h3>Estimasi Keuntungan</h3>

<h1 style="color:#ef4b2f;">

Rp <?= number_format($keuntungan); ?>

</h1>

<p>Estimasi laba 20%</p>

</div>

<div class="card">

<h3>Total Transaksi</h3>

<h1 style="color:#ef4b2f;">

<?= $trx['total']; ?>

</h1>

</div>

<div class="card">

<h3>Produk Terjual</h3>

<h1 style="color:#ef4b2f;">

<?= $produk['total']; ?>

</h1>

</div>

<div class="card">

<a
href="#"
onclick="window.print()"
class="btn-success"
>

<i class="fa-solid fa-print"></i>

Cetak Laporan

</a>

</div>

<h2 style="margin-top:20px;">

Riwayat Transaksi Minggu Ini

</h2>

<?php

if(mysqli_num_rows($data)==0){

?>

<div class="card">

Belum ada transaksi minggu ini.

</div>

<?php } ?>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<div class="card">

<h3>

<?= $row['nama']; ?>

</h3>

<p>

<?= date("d M Y H:i",strtotime($row['tanggal'])); ?>

</p>

<p>

Status :

<b style="color:green;">

<?= $row['status']; ?>

</b>

</p>

<h2 style="color:#ef4b2f;">

Rp <?= number_format($row['total']); ?>

</h2>

</div>

<?php } ?>

</div>

</body>
</html>