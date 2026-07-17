<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$id_produk = $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$deskripsi = $_POST['deskripsi'];

$foto = $_POST['foto_lama'];

if($_FILES['foto']['name'] != ''){

$foto = time().'_'.$_FILES['foto']['name'];

move_uploaded_file(
$_FILES['foto']['tmp_name'],
'../../assets/uploads/'.$foto
);

}

mysqli_query($conn,"
UPDATE produk SET
nama_produk='$nama_produk',
harga='$harga',
stok='$stok',
foto='$foto',
deskripsi='$deskripsi'
WHERE id_produk='$id_produk'
");

header("Location:index.php");
exit;
?>