<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Laporan Bulanan";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

/* ==========================
   BULAN SEKARANG
========================== */

$bulan=date("m");
$tahun=date("Y");

/* ==========================
   OMZET
========================== */

$omzet=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND status='Selesai'
"));

/* ==========================
   TRANSAKSI
========================== */

$trx=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
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
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND pesanan.status='Selesai'
"));

/* ==========================
   KEUNTUNGAN
========================== */

$keuntungan=$omzet['total']*20/100;

/* ==========================
   DATA TRANSAKSI
========================== */

$data=mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user=users.id_user
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND status='Selesai'
ORDER BY tanggal DESC
");

/* ==========================
   GRAFIK 30 HARI
========================== */

$label=[];
$grafik=[];

for($i=29;$i>=0;$i--){

$tgl=date("Y-m-d",strtotime("-".$i." day"));

$label[]=date("d/m",strtotime($tgl));

$q=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE DATE(tanggal)='$tgl'
AND status='Selesai'
"));

$grafik[]=$q['total'];

}

?>

<div class="page-content">

<div class="card">

<h2>

<i class="fa-solid fa-calendar-days"></i>

Laporan Bulanan

</h2>

<p>

<?= date("F Y"); ?>

</p>

</div>

<div class="card">

<h3>Omzet Bulan Ini</h3>

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

<h3>Grafik Omzet 30 Hari</h3>

<canvas id="grafikBulanan"></canvas>

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

Riwayat Transaksi Bulan Ini

</h2>

<?php

if(mysqli_num_rows($data)==0){

?>

<div class="card">

Belum ada transaksi bulan ini.

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

<script>

const ctx=document.getElementById('grafikBulanan');

new Chart(ctx,{

type:'line',

data:{

labels:[
<?= "'".implode("','",$label)."'" ?>
],

datasets:[{

label:'Omzet',

data:[
<?= implode(",",$grafik); ?>
],

borderWidth:3,

fill:false,

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