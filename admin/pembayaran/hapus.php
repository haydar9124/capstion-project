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

if($row['gambar']!=""){

$file="../../uploads/pembayaran/".$row['gambar'];

if(file_exists($file)){

unlink($file);

}

}

mysqli_query($conn,"
DELETE FROM metode_pembayaran
WHERE id_metode='$id'
");

echo"

<script>

alert('Metode pembayaran berhasil dihapus');

location='index.php';

</script>

";

exit;

?>