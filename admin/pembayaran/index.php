<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$judul="Metode Pembayaran";
$back_url="../dashboard.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

$data=mysqli_query($conn,"
SELECT *
FROM metode_pembayaran
ORDER BY id_metode ASC
");

?>

<div class="page-content">

<div class="card">

<h2>

<i class="fa-solid fa-money-check-dollar"></i>

Kelola Metode Pembayaran

</h2>

<p style="margin-top:8px;color:#666;">

Silakan kelola rekening Bank, Dana, OVO, GoPay maupun COD.

</p>

</div>

<a
href="tambah.php"
class="btn-success">

<i class="fa-solid fa-plus"></i>

Tambah Metode Pembayaran

</a>

<br>

<?php

while($row=mysqli_fetch_assoc($data)){

?>

<div class="card">

<div style="display:flex;justify-content:space-between;align-items:center;">

<div>

<h3>

<?= $row['nama_metode']; ?>

</h3>

<p>

Nomor

<br>

<b>

<?= $row['nomor']; ?>

</b>

</p>

<br>

<p>

Atas Nama

<br>

<b>

<?= $row['atas_nama']; ?>

</b>

</p>

<br>

<?php

if($row['status']=="Aktif"){

?>

<span class="badge-success">

Aktif

</span>

<?php

}else{

?>

<span class="badge-danger">

Nonaktif

</span>

<?php

}

?>

</div>

<div>

<?php

if($row['gambar']==""){

?>

<div style="width:90px;height:90px;background:#f2f2f2;border-radius:10px;display:flex;align-items:center;justify-content:center;">

<i class="fa-solid fa-image fa-2x"></i>

</div>

<?php

}else{

?>

<img
src="../../uploads/pembayaran/<?= $row['gambar']; ?>"
style="
width:90px;
height:90px;
border-radius:10px;
object-fit:cover;
">

<?php

}

?>

</div>

</div>

<br>

<a
href="edit.php?id=<?= $row['id_metode']; ?>"
class="btn-warning">

<i class="fa-solid fa-pen"></i>

Edit

</a>

<br>

<a
href="hapus.php?id=<?= $row['id_metode']; ?>"
class="btn-danger"
onclick="return confirm('Hapus metode pembayaran ini?')">

<i class="fa-solid fa-trash"></i>

Hapus

</a>

</div>

<?php

}

?>

</div>

</div>

</body>
</html>