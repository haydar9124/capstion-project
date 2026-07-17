<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$judul = "Keranjang";

include '../layout/header_user.php';
include '../layout/page_header.php';

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn,"
SELECT
keranjang.*,
produk.nama_produk,
produk.harga
FROM keranjang
JOIN produk
ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_user='$id_user'
");

$total = 0;
?>

<div class="container">

<div class="page-content">

<?php if(mysqli_num_rows($query)==0){ ?>

<div class="card">

<h3>Keranjang Kosong</h3>

<p>
Silakan pilih produk terlebih dahulu.
</p>

</div>

<?php } ?>

<?php while($row=mysqli_fetch_assoc($query)): ?>

<?php
$subtotal = $row['harga'] * $row['qty'];
$total += $subtotal;
?>

<div class="card">

<h3>
<?= $row['nama_produk']; ?>
</h3>

<br>

<p>
Harga :
Rp <?= number_format($row['harga']); ?>
</p>

<p>
Jumlah :
<?= $row['qty']; ?>
</p>

<p style="color:#ef4b2f;font-weight:bold;">
Subtotal :
Rp <?= number_format($subtotal); ?>
</p>

<br>

<a
href="hapus_keranjang.php?id=<?= $row['id_keranjang']; ?>"
class="btn-danger"
onclick="return confirm('Hapus produk ini?')"
>
Hapus
</a>

</div>

<?php endwhile; ?>

<?php if($total > 0){ ?>

<div class="card">

<h2 style="color:#ef4b2f;">
Total :
Rp <?= number_format($total); ?>
</h2>

</div>

<a
href="checkout.php"
class="btn-primary"
>
Lanjut Checkout
</a>

<?php } ?>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>