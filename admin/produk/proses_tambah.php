<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$nama_produk = $_POST['nama_produk'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$deskripsi = $_POST['deskripsi'];

$foto = '';

if($_FILES['foto']['name'] != ''){

$foto = time().'_'.$_FILES['foto']['name'];

move_uploaded_file(
$_FILES['foto']['tmp_name'],
'../../assets/uploads/'.$foto
);

}

mysqli_query($conn,"
INSERT INTO produk
(
nama_produk,
harga,
stok,
foto,
deskripsi
)
VALUES
(
'$nama_produk',
'$harga',
'$stok',
'$foto',
'$deskripsi'
)
");

header("Location:index.php");
exit;
?>