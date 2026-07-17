<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

$judul="Kelola Produk";
$back_url="../dashboard.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

$data=mysqli_query($conn,"
SELECT *
FROM produk
ORDER BY nama_produk ASC
");

?>

<div class="page-content">

<a
href="tambah.php"
class="btn-success"
style="margin-bottom:20px;"
>

<i class="fa-solid fa-plus"></i>

Tambah Produk

</a>

<?php while($row=mysqli_fetch_assoc($data)){ ?>

<div class="card">

<?php

if($row['foto']!=""){

?>

<img
src="../../assets/uploads/<?= $row['foto']; ?>"
style="
width:100%;
height:190px;
object-fit:cover;
border-radius:12px;
margin-bottom:15px;
">

<?php

}else{

?>

<div
style="
height:190px;
background:#eee;
display:flex;
justify-content:center;
align-items:center;
border-radius:12px;
margin-bottom:15px;
">

<i
class="fa-solid fa-image"
style="
font-size:60px;
color:#999;
"></i>

</div>

<?php } ?>

<h2>

<?= $row['nama_produk']; ?>

</h2>

<br>

<p>

Harga

</p>

<h3 style="color:#ef4b2f;">

Rp <?= number_format($row['harga']); ?>

</h3>

<br>

<p>

Stok

<b>

<?= $row['stok']; ?>

</b>

</p>

<?php

$persen=0;

if($row['stok']>=100){

$persen=100;

}else{

$persen=$row['stok'];

}

?>

<div
style="
width:100%;
height:10px;
background:#ddd;
border-radius:20px;
overflow:hidden;
margin-top:10px;
">

<div

style="
width:<?= $persen; ?>%;
height:10px;

<?php

if($row['stok']<=0){

echo "background:red;";

}elseif($row['stok']<=10){

echo "background:orange;";

}else{

echo "background:#28a745;";

}

?>

">

</div>

</div>

<br>

<?php

if($row['stok']<=0){

?>

<span
style="
background:red;
padding:6px 12px;
color:white;
border-radius:20px;
">

Stok Habis

</span>

<?php

}elseif($row['stok']<=10){

?>

<span
style="
background:orange;
padding:6px 12px;
color:white;
border-radius:20px;
">

Stok Menipis

</span>

<?php

}else{

?>

<span
style="
background:#28a745;
padding:6px 12px;
color:white;
border-radius:20px;
">

Stok Aman

</span>

<?php } ?>

<br><br>

<a
href="edit.php?id=<?= $row['id_produk']; ?>"
class="btn-warning"
>

<i class="fa-solid fa-pen"></i>

Edit

</a>

<br>

<a
href="hapus.php?id=<?= $row['id_produk']; ?>"
class="btn-danger"
onclick="return confirm('Yakin ingin menghapus produk ini?')"
>

<i class="fa-solid fa-trash"></i>

Hapus

</a>

</div>

<?php } ?>

</div>

</div>

</body>
</html>