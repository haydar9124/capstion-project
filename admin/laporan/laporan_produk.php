<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Laporan Produk Terjual";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

/* ==========================
   BULAN SEKARANG
========================== */
$bulan=date("m");
$tahun=date("Y");

/* ==========================
   TOTAL PRODUK TERJUAL BULAN INI
========================== */
$produk_bulan_ini=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(qty),0) total
FROM detail_pesanan
JOIN pesanan ON detail_pesanan.id_pesanan=pesanan.id_pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND pesanan.status='Selesai'
"));

/* ==========================
   TOTAL JENIS PRODUK TERJUAL (Variasi Unik)
========================== */
$jenis_terjual=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(DISTINCT id_produk) total
FROM detail_pesanan
JOIN pesanan ON detail_pesanan.id_pesanan=pesanan.id_pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND pesanan.status='Selesai'
"));

/* ==========================
   DATA DETAIL PRODUK TERJUAL (Dikelompokkan & Urut Terlaris)
========================== */
$data=mysqli_query($conn,"
SELECT 
produk.nama_produk,
IFNULL(SUM(detail_pesanan.qty),0) as total_qty,
IFNULL(SUM(detail_pesanan.subtotal),0) as total_omzet
FROM detail_pesanan
JOIN pesanan ON detail_pesanan.id_pesanan=pesanan.id_pesanan
JOIN produk ON detail_pesanan.id_produk=produk.id_produk
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND pesanan.status='Selesai'
GROUP BY detail_pesanan.id_produk
ORDER BY total_qty DESC
");

/* ==========================
   GRAFIK PENJUALAN PRODUK (QTY) 30 HARI
========================== */
$label=[];
$grafik=[];

for($i=29;$i>=0;$i--){
    $tgl=date("Y-m-d",strtotime("-".$i." day"));
    $label[]=date("d/m",strtotime($tgl));

    $q=mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT IFNULL(SUM(qty),0) total
    FROM detail_pesanan
    JOIN pesanan ON detail_pesanan.id_pesanan=pesanan.id_pesanan
    WHERE DATE(tanggal)='$tgl'
    AND pesanan.status='Selesai'
    "));

    $grafik[]=$q['total'];
}

?>

<div class="page-content">

<div class="card">
    <h2>
        <i class="fa-solid fa-box"></i>
        Laporan Produk Terjual
    </h2>
    <p>
        <?= date("F Y"); ?>
    </p>
</div>

<div class="card">
    <h3>Total Qty Produk Terjual (Bulan Ini)</h3>
    <h1 style="color:green;">
        <?= number_format($produk_bulan_ini['total']); ?> pcs
    </h1>
</div>

<div class="card">
    <h3>Variasi Produk Terjual (Bulan Ini)</h3>
    <h1 style="color:#ef4b2f;">
        <?= $jenis_terjual['total']; ?> Jenis Produk
    </h1>
    <p>Jumlah item unik yang berhasil dipasarkan</p>
</div>

<div class="card">
    <h3>Grafik Volume Penjualan (Pcs) 30 Hari Terakhir</h3>
    <canvas id="grafikProduk"></canvas>
</div>

<div class="card">
    <a href="#" onclick="window.print()" class="btn-success">
        <i class="fa-solid fa-print"></i>
        Cetak Laporan Produk
    </a>
</div>

<h2 style="margin-top:20px;">
    Daftar Produk Terlaris Bulan Ini
</h2>

<?php if(mysqli_num_rows($data)==0){ ?>
    <div class="card">
        Belum ada produk yang terjual bulan ini.
    </div>
<?php } ?>

<?php 
$rank = 1;
while($row=mysqli_fetch_assoc($data)){ 
?>
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px;">
                #<?= $rank++; ?> <?= htmlspecialchars($row['nama_produk']); ?>
            </h3>
            <span style="background: #ef4b2f; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                <?= $row['total_qty']; ?> Pcs
            </span>
        </div>
        <hr style="margin: 10px 0; border: 0; border-top: 1px dashed #eee;">
        <p style="margin: 0; color: #666; font-size: 13px;">
            Total Penjualan Kotor (Bruto): <b style="color: #333;">Rp <?= number_format($row['total_omzet']); ?></b>
        </p>
    </div>
<?php } ?>

</div>

<script>
const ctx=document.getElementById('grafikProduk');

new Chart(ctx,{
    type:'bar', // Menggunakan chart batang untuk representasi fisik barang
    data:{
        labels:[
            <?= "'".implode("','",$label)."'" ?>
        ],
        datasets:[{
            label:'Produk Terjual (Pcs)',
            data:[
                <?= implode(",",$grafik); ?>
            ],
            backgroundColor:'#2563eb', // Warna biru untuk aksen produk
            borderWidth:1
        }]
    },
    options:{
        responsive:true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

</body>
</html>
