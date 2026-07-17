<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$data = mysqli_query($conn,"
SELECT *
FROM produk
ORDER BY id_produk DESC
");

include '../layout/header_user.php';
?>

<div class="container">

<div class="topbar">

<div class="topbar-left">

<span class="topbar-title">
E-Warung
</span>

</div>

<i class="fa-solid fa-store"></i>

</div>

<div class="page-content">

<h2 style="margin-bottom:20px;">
Halo, <?= $_SESSION['nama']; ?>
</h2>

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
Lihat Detail
</a>

</div>

<?php endwhile; ?>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</div>

</body>
</html>