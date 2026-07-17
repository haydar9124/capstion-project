<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama=$_POST['nama_metode'];
    $nomor=$_POST['nomor'];
    $atas=$_POST['atas_nama'];
    $status=$_POST['status'];

    $gambar="";

    if($_FILES['gambar']['name']!=""){

        $namaFile=time()."_".$_FILES['gambar']['name'];

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            "../../uploads/pembayaran/".$namaFile
        );

        $gambar=$namaFile;

    }

    mysqli_query($conn,"
    INSERT INTO metode_pembayaran
    (
    nama_metode,
    nomor,
    atas_nama,
    gambar,
    status
    )
    VALUES
    (
    '$nama',
    '$nomor',
    '$atas',
    '$gambar',
    '$status'
    )
    ");

    echo"

    <script>

    alert('Metode pembayaran berhasil ditambahkan');

    location='index.php';

    </script>

    ";

}

$judul="Tambah Metode Pembayaran";
$back_url="index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

<div class="card">

<h2>

<i class="fa-solid fa-plus"></i>

Tambah Metode Pembayaran

</h2>

</div>

<form
method="POST"
enctype="multipart/form-data"
>

<div class="card">

<label>

Nama Metode

</label>

<input
type="text"
name="nama_metode"
placeholder="Contoh : Transfer BCA"
required
>

<label>

Nomor Rekening / Nomor E-Wallet

</label>

<input
type="text"
name="nomor"
required
>

<label>

Atas Nama

</label>

<input
type="text"
name="atas_nama"
required
>

<label>

Upload Logo / QRIS / QR Bank

</label>

<input
type="file"
name="gambar"
accept="image/*"
>

<label>

Status

</label>

<select
name="status"
required
>

<option value="Aktif">

Aktif

</option>

<option value="Nonaktif">

Nonaktif

</option>

</select>

<button
type="submit"
name="simpan"
class="btn-success"
>

<i class="fa-solid fa-floppy-disk"></i>

Simpan

</button>

<br>

<a
href="index.php"
class="btn-danger"
>

Batal

</a>

</div>

</form>

</div>

</div>

</body>

</html>