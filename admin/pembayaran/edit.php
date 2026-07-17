<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$id=isset($_GET['id'])?(int)$_GET['id']:0;

$data=mysqli_query($conn,"
SELECT *
FROM metode_pembayaran
WHERE id_metode='$id'
LIMIT 1
");

if(mysqli_num_rows($data)==0){

echo"

<script>

alert('Data tidak ditemukan');

location='index.php';

</script>

";

exit;

}

$row=mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

$nama=mysqli_real_escape_string($conn,$_POST['nama_metode']);
$nomor=mysqli_real_escape_string($conn,$_POST['nomor']);
$atas=mysqli_real_escape_string($conn,$_POST['atas_nama']);
$status=mysqli_real_escape_string($conn,$_POST['status']);

$gambar=$row['gambar'];

if(isset($_FILES['gambar']) && $_FILES['gambar']['name']!=""){

if($gambar!="" && file_exists("../../uploads/pembayaran/".$gambar)){

unlink("../../uploads/pembayaran/".$gambar);

}

$ext=pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION);

$namaBaru=time()."_".rand(1000,9999).".".$ext;

move_uploaded_file(
$_FILES['gambar']['tmp_name'],
"../../uploads/pembayaran/".$namaBaru
);

$gambar=$namaBaru;

}

mysqli_query($conn,"
UPDATE metode_pembayaran
SET
nama_metode='$nama',
nomor='$nomor',
atas_nama='$atas',
gambar='$gambar',
status='$status'
WHERE id_metode='$id'
");

echo"

<script>

alert('Data berhasil diperbarui');

location='index.php';

</script>

";

exit;

}

$judul="Edit Metode Pembayaran";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card">

<h2>

<i class="fa-solid fa-pen"></i>

Edit Metode Pembayaran

</h2>

</div>

<form
method="POST"
enctype="multipart/form-data"
>

<div class="card">

<label>

Nama Metode

</label>

<input
type="text"
name="nama_metode"
value="<?= htmlspecialchars($row['nama_metode']); ?>"
required
>

<label>

Nomor Rekening / Nomor E-Wallet

</label>

<input
type="text"
name="nomor"
value="<?= htmlspecialchars($row['nomor']); ?>"
required
>

<label>

Atas Nama

</label>

<input
type="text"
name="atas_nama"
value="<?= htmlspecialchars($row['atas_nama']); ?>"
required
>

<?php if($row['gambar']!=""){ ?>

<center>

<img
src="../../uploads/pembayaran/<?= $row['gambar']; ?>"
style="
width:180px;
border-radius:12px;
margin:15px 0;
box-shadow:0 2px 10px rgba(0,0,0,.15);
">

</center>

<?php } ?>

<label>

Ganti QR / Logo

</label>

<input
type="file"
name="gambar"
accept="image/*"
>

<label>

Status

</label>

<select
name="status"
required
>

<option
value="Aktif"
<?= $row['status']=="Aktif"?"selected":""; ?>
>

Aktif

</option>

<option
value="Nonaktif"
<?= $row['status']=="Nonaktif"?"selected":""; ?>
>

Nonaktif

</option>

</select>

<button
type="submit"
name="update"
class="btn-success"
>

<i class="fa-solid fa-floppy-disk"></i>

Simpan Perubahan

</button>

<br>

<a
href="index.php"
class="btn-danger"
>

Batal

</a>

</div>

</form>

</div>

</body>

</html>