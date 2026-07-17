<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

date_default_timezone_set("Asia/Jakarta");

$id_pesanan = $_POST['id_pesanan'];
$status_baru = $_POST['status'];

mysqli_begin_transaction($conn);

try{

$pesanan = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM pesanan
WHERE id_pesanan='$id_pesanan'"
)
);

if(!$pesanan){

throw new Exception("Pesanan tidak ditemukan.");

}

$status_lama = $pesanan['status'];

if($status_lama != "Dibatalkan" && $status_baru == "Dibatalkan"){

$detail = mysqli_query(
$conn,
"SELECT *
FROM detail_pesanan
WHERE id_pesanan='$id_pesanan'"
);

while($row=mysqli_fetch_assoc($detail)){

mysqli_query(
$conn,
"UPDATE produk
SET stok = stok + ".$row['qty']."
WHERE id_produk='".$row['id_produk']."'"
);

}

}

mysqli_query(
$conn,
"UPDATE pesanan
SET status='$status_baru'
WHERE id_pesanan='$id_pesanan'"
);

mysqli_commit($conn);

echo "

<script>

alert('Status pesanan berhasil diperbarui.');

window.location='detail.php?id=$id_pesanan';

</script>

";

}catch(Exception $e){

mysqli_rollback($conn);

echo "

<script>

alert('".$e->getMessage()."');

window.location='index.php';

</script>

";

}

?>