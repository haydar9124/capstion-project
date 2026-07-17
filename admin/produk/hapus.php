<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM produk
WHERE id_produk='$id'"
)
);

if(!empty($data['foto'])){

$file = "../../assets/uploads/".$data['foto'];

if(file_exists($file)){
unlink($file);
}

}

mysqli_query(
$conn,
"DELETE FROM produk
WHERE id_produk='$id'"
);

header("Location:index.php");
exit;
?>