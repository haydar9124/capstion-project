<?php

include '../config/koneksi.php';

// Amankan input dari SQL Injection
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi'];

// 1. Validasi kecocokan password
if ($password != $konfirmasi) {
    echo "
    <script>
    alert('Konfirmasi password tidak cocok');
    history.back();
    </script>
    ";
    exit;
}

// 2. Validasi apakah email sudah terdaftar sebelumnya
$cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email='$email' LIMIT 1");
if (mysqli_num_rows($cek_email) > 0) {
    echo "
    <script>
    alert('Email sudah terdaftar! Gunakan email lain.');
    history.back();
    </script>
    ";
    exit;
}

// 3. Enkripsi password agar aman di database
$password_aman = password_hash($password, PASSWORD_DEFAULT);

// 4. Proses Insert ke database
$query_insert = mysqli_query($conn, "
    INSERT INTO users (
        nama,
        email,
        password,
        no_hp,
        role
    ) VALUES (
        '$nama',
        '$email',
        '$password_aman',
        '$no_hp',
        'user'
    )
");

if ($query_insert) {
    echo "
    <script>
    alert('Registrasi berhasil! Silakan login.');
    window.location='login.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Gagal melakukan registrasi, coba lagi.');
    history.back();
    </script>
    ";
}
?>