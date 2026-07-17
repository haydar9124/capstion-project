<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Laporan Keuntungan";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

/* ==========================
   BULAN SEKARANG
========================== */
$bulan=date("m");
$tahun=date("Y");

/* ==========================
   TOTAL OMZET BULAN INI
========================== */
$omzet=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND status='Selesai'
"));

/* ==========================
   TOTAL TRANSAKSI BULAN INI
========================== */
$trx=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM pesanan
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
AND status='Selesai'
"));

/* ==========================
   ESTIMASI KEUNTUNGAN BULAN INI (Laba 20%)
========================== */
$keuntungan_bulan_ini = $omzet['total'] * 20 / 100;

/* ==========================
   ESTIMASI KEUNTUNGAN TOTAL (Sepanjang Masa)
========================== */
$omzet_total=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total),0) total
FROM pesanan
WHERE status='Selesai'
"));
$keuntungan_total = $omzet_total['total'] * 20 / 100;

/* ==========================
   DATA TRANSAKSI KHUSUS KEUNTUNGAN
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
   GRAFIK KEUNTUNGAN 30 HARI
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

    // Keuntungan per hari dihitung 20% dari total transaksi hari tersebut
    $keuntungan_harian = $q['total'] * 20 / 100;
    $grafik[]=$keuntungan_harian;
}

?>

<div class="page-content">

<div class="card">
    <h2>
        <i class="fa-solid fa-chart-line"></i>
        Laporan Keuntungan
    </h2>
    <p>
        <?= date("F Y"); ?>
    </p>
</div>

<div class="card">
    <h3>Estimasi Keuntungan Bulan Ini</h3>
    <h1 style="color:green;">
        Rp <?= number_format($keuntungan_bulan_ini); ?>
    </h1>
    <p>Diambil dari 20% total omzet bulan ini (Rp <?= number_format($omzet['total']); ?>)</p>
</div>

<div class="card">
    <h3>Estimasi Keuntungan Akumulatif (Semua)</h3>
    <h1 style="color:#ef4b2f;">
        Rp <?= number_format($keuntungan_total); ?>
    </h1>
    <p>Total keuntungan bersih sepanjang masa</p>
</div>

<div class="card">
    <h3>Total Transaksi Berhasil</h3>
    <h1 style="color:#ef4b2f;">
        <?= $trx['total']; ?> Trx
    </h1>
</div>

<div class="card">
    <h3>Grafik Keuntungan 30 Hari Terakhir</h3>
    <canvas id="grafikKeuntungan"></canvas>
</div>

<div class="card">
    <a href="#" onclick="window.print()" class="btn-success">
        <i class="fa-solid fa-print"></i>
        Cetak Laporan Keuntungan
    </a>
</div>

<h2 style="margin-top:20px;">
    Rincian Profit per Transaksi Bulan Ini
</h2>

<?php if(mysqli_num_rows($data)==0){ ?>
    <div class="card">
        Belum ada transaksi bulan ini.
    </div>
<?php } ?>

<?php while($row=mysqli_fetch_assoc($data)){ 
    $profit_per_item = $row['total'] * 20 / 100;
?>
    <div class="card">
        <h3>
            <?= htmlspecialchars($row['nama']); ?>
        </h3>
        <p>
            <?= date("d M Y H:i",strtotime($row['tanggal'])); ?>
        </p>
        <p>
            Nilai Transaksi: <b>Rp <?= number_format($row['total']); ?></b>
        </p>
        <p style="margin-top: 5px;">
            Estimasi Keuntungan (20%):
        </p>
        <h2 style="color:green; margin-top: 0;">
            + Rp <?= number_format($profit_per_item); ?>
        </h2>
    </div>
<?php } ?>

</div>

<script>
const ctx=document.getElementById('grafikKeuntungan');

new Chart(ctx,{
    type:'line',
    data:{
        labels:[
            <?= "'".implode("','",$label)."'" ?>
        ],
        datasets:[{
            label:'Keuntungan (20%)',
            data:[
                <?= implode(",",$grafik); ?>
            ],
            borderColor:'#ef4b2f',
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