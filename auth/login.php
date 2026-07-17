<?php
session_start();

if(isset($_SESSION['login'])){

    if($_SESSION['role']=="admin"){
        header("Location: ../admin/dashboard.php");
    }else{
        header("Location: ../user/dashboard.php");
    }

    exit;
}

include '../layout/header.php';
?>

<div class="container">

<div class="auth-header">

<i class="fa-solid fa-store" style="font-size:70px;color:white;"></i>

<h2>E-Warung</h2>

</div>

<div class="form-box">

<h3 style="margin-bottom:20px;">
Login
</h3>

<form action="proses_login.php" method="POST">

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>Password</label>
<div style="position: relative; display: flex; align-items: center;">
    <input type="password" name="password" id="loginPassword" required style="padding-right: 40px; width: 100%;">
    <i class="fa-solid fa-eye" id="toggleLoginPassword" style="position: absolute; right: 15px; cursor: pointer; color: #666;"></i>
</div>
</div>

<button class="btn" type="submit">
LOGIN
</button>

</form>

<p class="text-center" style="margin-top:20px;">
Belum punya akun?
<a href="register.php" class="link">
Daftar
</a>
</p>

</div>

</div>

<script>
const toggleLoginPassword = document.querySelector('#toggleLoginPassword');
const loginPassword = document.querySelector('#loginPassword');

toggleLoginPassword.addEventListener('click', function () {
    // Ubah tipe input
    const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    loginPassword.setAttribute('type', type);
    
    // Ubah ikon mata
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>

<?php include '../layout/footer.php'; ?>