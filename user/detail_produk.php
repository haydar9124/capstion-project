<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT *
FROM produk
WHERE id_produk='$id'
");

$p = mysqli_fetch_assoc($data);

$judul = "Detail Produk";

include '../layout/header_user.php';
include '../layout/page_header.php';

?>

<div class="page-content">

<div class="card">

<?php if(!empty($p['foto'])){ ?>

<img
src="../assets/uploads/<?= $p['foto']; ?>"
style="
width:100%;
height:250px;
object-fit:cover;
border-radius:12px;
margin-bottom:15px;
">

<?php } ?>

<h2>
<?= $p['nama_produk']; ?>
</h2>

<br>

<h3 style="color:#ef4b2f;">
Rp <?= number_format($p['harga']); ?>
</h3>

<br>

<p>
<?= $p['deskripsi']; ?>
</p>

<br>

<p>
Stok :
<b><?= $p['stok']; ?></b>
</p>

<br>

<form
action="tambah_keranjang.php"
method="POST"
>

<input
type="hidden"
name="id_produk"
value="<?= $p['id_produk']; ?>"
>

<label>Jumlah</label>

<input
type="number"
name="qty"
value="1"
min="1"
required
>

<button
type="submit"
class="btn-primary"
>
Tambah Ke Keranjang
</button>

</form>

</div>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>