<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$id_user=$_SESSION['id_user'];

$data=mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT * FROM users
WHERE id_user='$id_user'"
)
);

$judul="Profil Saya";

include '../layout/header_user.php';
include '../layout/page_header.php';

?>

<div class="container">

<div class="page-content">

<div class="card" style="text-align:center;">

<i
class="fa-solid fa-circle-user"
style="
font-size:90px;
color:#ef4b2f;
">
</i>

<h2 style="margin-top:15px;">
<?= $data['nama']; ?>
</h2>

<p>
<?= $data['email']; ?>
</p>

</div>

<div class="card">

<p><b>Nama</b></p>
<p><?= $data['nama']; ?></p>

<br>

<p><b>Email</b></p>
<p><?= $data['email']; ?></p>

<br>

<p><b>No HP</b></p>
<p><?= $data['no_hp']; ?></p>

</div>

<a
href="edit_profil.php"
class="btn-primary"
>
Edit Profil
</a>

<br>

<a
href="../auth/logout.php"
class="btn-danger"
onclick="return confirm('Logout ?')"
>
Logout
</a>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>