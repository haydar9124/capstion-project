<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$judul = "Checkout";

include '../layout/header_user.php';
include '../layout/page_header.php';

$id_user = $_SESSION['id_user'];

$data = mysqli_query($conn,"
SELECT
keranjang.*,
produk.nama_produk,
produk.harga
FROM keranjang
JOIN produk
ON keranjang.id_produk=produk.id_produk
WHERE keranjang.id_user='$id_user'
");

$total = 0;

?>

<div class="container">

<div class="page-content">

<div class="card">

<form
action="proses_checkout.php"
method="POST"
onsubmit="return yakinPesan()"
>

<label>Alamat Lengkap</label>

<textarea
name="alamat"
required
style="height:120px;"
></textarea>

<label>Metode Pembayaran</label>

<select
name="metode"
id="metode"
required
onchange="tampilPembayaran()"
>

<option value="">-- Pilih Metode Pembayaran --</option>

<?php

$metode=mysqli_query($conn,"
SELECT *
FROM metode_pembayaran
WHERE status='Aktif'
ORDER BY id_metode ASC
");

while($m=mysqli_fetch_assoc($metode)){

?>

<option
value="<?= $m['id_metode']; ?>"
data-nama="<?= $m['nama_metode']; ?>"
data-nomor="<?= $m['nomor']; ?>"
data-atas="<?= $m['atas_nama']; ?>"
data-gambar="<?= $m['gambar']; ?>"
>

<?= $m['nama_metode']; ?>

</option>

<?php } ?>

</select>

<div
id="infoPembayaran"
style="
display:none;
margin-top:20px;
"
>

<div class="card">

<h3>

Informasi Pembayaran

</h3>

<br>

<p>

<b>Metode</b>

</p>

<p id="namaMetode"></p>

<br>

<p>

<b>Nomor Rekening / E-Wallet</b>

</p>

<p id="nomorPembayaran"></p>

<br>

<p>

<b>Atas Nama</b>

</p>

<p id="atasNama"></p>

<br>

<img
id="gambarQR"
style="
width:220px;
display:none;
border-radius:12px;
margin:auto;
"
>

</div>

</div>
<hr style="margin:20px 0;">

<h3>Ringkasan Belanja</h3>

<br>

<?php while($row=mysqli_fetch_assoc($data)): ?>

<?php
$subtotal = $row['harga'] * $row['qty'];
$total += $subtotal;
?>

<p>

<?= $row['nama_produk']; ?>

(x<?= $row['qty']; ?>)

</p>

<p style="color:#ef4b2f;margin-bottom:10px;">

Rp <?= number_format($subtotal); ?>

</p>

<?php endwhile; ?>

<hr style="margin:20px 0;">

<h2 style="color:#ef4b2f;">

Total :
Rp <?= number_format($total); ?>

</h2>

<input
type="hidden"
name="total"
value="<?= $total; ?>"
>

<br>

<button
type="submit"
class="btn-primary"
>
Buat Pesanan
</button>

</form>

</div>

</div>

</div>

<?php include '../layout/navbar_bottom.php'; ?>

<script>

function tampilPembayaran(){

let select=document.getElementById("metode");

let option=select.options[select.selectedIndex];

let nama=option.getAttribute("data-nama");

let nomor=option.getAttribute("data-nomor");

let atas=option.getAttribute("data-atas");

let gambar=option.getAttribute("data-gambar");

let box=document.getElementById("infoPembayaran");

let img=document.getElementById("gambarQR");

if(select.value==""){

box.style.display="none";

return;

}

if(nama=="COD"){

box.style.display="none";

return;

}

box.style.display="block";

document.getElementById("namaMetode").innerHTML=nama;

document.getElementById("nomorPembayaran").innerHTML=nomor;

document.getElementById("atasNama").innerHTML=atas;

if(gambar!=""){

img.src="../uploads/pembayaran/"+gambar;

img.style.display="block";

}else{

img.style.display="none";

}

}

function yakinPesan(){

return confirm("Apakah Anda yakin ingin membuat pesanan ini?");

}

</script>
</body>
</html>