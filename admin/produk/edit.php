<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$id=$_GET['id'];

$data=mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM produk
WHERE id_produk='$id'"
)
);

$judul="Edit Produk";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card">

<?php if($data['foto']){ ?>

<img
src="../../assets/uploads/<?= $data['foto']; ?>"
style="
width:100%;
height:220px;
object-fit:cover;
border-radius:12px;
margin-bottom:15px;
">

<?php } ?>

<form
action="proses_edit.php"
method="POST"
enctype="multipart/form-data"
>

<input
type="hidden"
name="id_produk"
value="<?= $data['id_produk']; ?>"
>

<input
type="hidden"
name="foto_lama"
value="<?= $data['foto']; ?>"
>

<label>Nama Produk</label>

<input
type="text"
name="nama_produk"
value="<?= $data['nama_produk']; ?>"
required
>

<label>Harga</label>

<input
type="number"
name="harga"
value="<?= $data['harga']; ?>"
required
>

<label>Stok</label>

<input
type="number"
name="stok"
value="<?= $data['stok']; ?>"
required
>

<label>Ganti Foto</label>

<input
type="file"
name="foto"
accept="image/*"
>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"
required
><?= $data['deskripsi']; ?></textarea>

<button
type="submit"
class="btn-warning"
>
Update Produk
</button>

</form>

</div>

</div>

</div>

</body>
</html>