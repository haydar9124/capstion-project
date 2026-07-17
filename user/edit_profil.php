<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$data = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT *
FROM users
WHERE id_user='$id_user'"
)
);

$judul = "Edit Profil";

include '../layout/header_user.php';
include '../layout/page_header.php';

?>

<div class="container">

<div class="page-content">

<div class="card">

<form
action="update_profil.php"
method="POST"
>

<input
type="hidden"
name="id_user"
value="<?= $data['id_user']; ?>"
>

<label>Nama Lengkap</label>

<input
type="text"
name="nama"
value="<?= $data['nama']; ?>"
required
>

<label>Email</label>

<input
type="email"
value="<?= $data['email']; ?>"
readonly
>

<label>No HP</label>

<input
type="text"
name="no_hp"
value="<?= $data['no_hp']; ?>"
required
>

<button
type="submit"
class="btn-primary"
>
Simpan Perubahan
</button>

</form>

</div>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>