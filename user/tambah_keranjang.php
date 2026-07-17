<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];
$id_produk = $_POST['id_produk'];
$qty = $_POST['qty'];

$cek = mysqli_query(
$conn,
"SELECT * FROM keranjang
WHERE id_user='$id_user'
AND id_produk='$id_produk'"
);

if(mysqli_num_rows($cek)>0){

$data = mysqli_fetch_assoc($cek);

$qty_baru = $data['qty'] + $qty;

mysqli_query(
$conn,
"UPDATE keranjang
SET qty='$qty_baru'
WHERE id_keranjang='".$data['id_keranjang']."'"
);

}else{

mysqli_query(
$conn,
"INSERT INTO keranjang
(
id_user,
id_produk,
qty
)
VALUES
(
'$id_user',
'$id_produk',
'$qty'
)"
);

}

echo "
<script>
alert('Produk berhasil ditambahkan');
window.location='keranjang.php';
</script>
";
?>