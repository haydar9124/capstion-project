<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$judul="Tambah Produk";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card">

<form
action="proses_tambah.php"
method="POST"
enctype="multipart/form-data"
>

<label>Nama Produk</label>

<input
type="text"
name="nama_produk"
required
>

<label>Harga</label>

<input
type="number"
name="harga"
required
>

<label>Stok</label>

<input
type="number"
name="stok"
required
>

<label>Foto Produk</label>

<input
type="file"
name="foto"
accept="image/*"
required
>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"
required
></textarea>

<button
type="submit"
class="btn-success"
>
Simpan Produk
</button>

</form>

</div>

</div>

</div>

</body>
</html>