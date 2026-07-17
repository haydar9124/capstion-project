<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$judul = "Produk";
$back_url = "home.php";

include '../layout/header_user.php';
include '../layout/page_header.php';

$data = mysqli_query($conn,"
SELECT *
FROM produk
ORDER BY id_produk DESC
");

?>

<div class="page-content">

<?php while($row=mysqli_fetch_assoc($data)): ?>

<div class="card">

<?php if(!empty($row['foto'])){ ?>

<img
src="../assets/uploads/<?= $row['foto']; ?>"
style="
width:100%;
height:180px;
object-fit:cover;
border-radius:12px;
margin-bottom:15px;
">

<?php } ?>

<h3>
<?= $row['nama_produk']; ?>
</h3>

<br>

<h3 style="color:#ef4b2f;">
Rp <?= number_format($row['harga']); ?>
</h3>

<br>

<p>
<?= substr($row['deskripsi'],0,100); ?>...
</p>

<br>

<a
href="detail_produk.php?id=<?= $row['id_produk']; ?>"
class="btn-primary"
>
Detail Produk
</a>

</div>

<?php endwhile; ?>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>