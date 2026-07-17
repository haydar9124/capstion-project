<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$judul = "Kelola Pesanan";
$back_url = "../dashboard.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

$data = mysqli_query($conn,"
SELECT
pesanan.*,
users.nama
FROM pesanan
JOIN users
ON pesanan.id_user = users.id_user
ORDER BY pesanan.id_pesanan DESC
");

?>

<div class="page-content">

<?php while($row=mysqli_fetch_assoc($data)): ?>

<div class="card">

<h3>
Pesanan #<?= $row['id_pesanan']; ?>
</h3>

<br>

<p>
Pelanggan :
<b><?= $row['nama']; ?></b>
</p>

<p>
Total :
<b>Rp <?= number_format($row['total']); ?></b>
</p>

<p>
Status :
<b><?= $row['status']; ?></b>
</p>

<br>

<a
href="detail.php?id=<?= $row['id_pesanan']; ?>"
class="btn-primary"
>
Lihat Detail
</a>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>