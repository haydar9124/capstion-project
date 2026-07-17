<?php

session_start();
include '../config/koneksi.php';

// Amankan input dari SQL Injection
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password']; // Tidak perlu escape karena nanti dicocokkan lewat password_verify

$query = mysqli_query($conn, "
    SELECT *
    FROM users
    WHERE email='$email'
    LIMIT 1
");

if (mysqli_num_rows($query) > 0) {

    $data = mysqli_fetch_assoc($query);

    // Verifikasi password (mendukung teks biasa lama DAN hash baru)
    if (password_verify($password, $data['password']) || $password == $data['password']) {

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } else {
            header("Location: ../user/dashboard.php");
        }
        exit;

    } else {
        echo "
        <script>
        alert('Password Salah');
        window.location='login.php';
        </script>
        ";
    }

} else {
    echo "
    <script>
    alert('Email Tidak Ditemukan');
    window.location='login.php';
    </script>
    ";
}
?>