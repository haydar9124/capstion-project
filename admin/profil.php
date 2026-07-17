<?php

include '../config/session_admin.php';

$judul="Profil Admin";

include '../layout/header_admin.php';
include '../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card" style="text-align:center;">

<i
class="fa-solid fa-user-shield"
style="
font-size:90px;
color:#ef4b2f;
">
</i>

<h2 style="margin-top:15px;">
<?= $_SESSION['nama']; ?>
</h2>

<p>Administrator E-Warung</p>

</div>

<div class="card">

<p>
Nama :
<b><?= $_SESSION['nama']; ?></b>
</p>

<br>

<p>
Email :
<b><?= $_SESSION['email']; ?></b>
</p>

</div>

<a
href="../auth/logout.php"
class="btn-danger"
onclick="return confirm('Logout ?')"
>
Logout
</a>

</div>

</div>

</body>
</html>