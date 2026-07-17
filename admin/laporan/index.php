<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$judul="Menu Laporan";
$back_url="../dashboard.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card" style="text-align:center;">

<h2>

<i class="fa-solid fa-file-lines"></i>

Menu Laporan

</h2>

<p>

Pilih jenis laporan yang ingin ditampilkan.

</p>

</div>

<a
href="laporan_harian.php"
class="btn-primary"
>

<i class="fa-solid fa-calendar-day"></i>

Laporan Harian

</a>

<br>

<a
href="laporan_mingguan.php"
class="btn-warning"
>

<i class="fa-solid fa-calendar-week"></i>

Laporan Mingguan

</a>

<br>

<a
href="laporan_bulanan.php"
class="btn-success"
>

<i class="fa-solid fa-calendar-days"></i>

Laporan Bulanan

</a>

<br>

<a
href="laporan_keuntungan.php"
class="btn-primary"
style="background:#8b5cf6;"
>

<i class="fa-solid fa-sack-dollar"></i>

Laporan Keuntungan

</a>

<br>

<a
href="laporan_produk.php"
class="btn-warning"
style="background:#0ea5e9;"
>

<i class="fa-solid fa-box"></i>

Laporan Produk Terjual

</a>

</div>

</body>

</html>