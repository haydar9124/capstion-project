<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$id_user = $_POST['id_user'];
$nama = $_POST['nama'];
$no_hp = $_POST['no_hp'];

mysqli_query(
$conn,
"UPDATE users SET
nama='$nama',
no_hp='$no_hp'
WHERE id_user='$id_user'"
);

$_SESSION['nama'] = $nama;

echo "
<script>
alert('Profil berhasil diperbarui');
window.location='profil.php';
</script>
";
?>