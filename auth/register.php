<?php
include '../layout/header.php';
?>

<div class="container">

<div class="auth-header">

<i class="fa-solid fa-user-plus" style="font-size:70px;color:white;"></i>

<h2>Daftar Akun</h2>

</div>

<div class="form-box">

<form action="proses_register.php" method="POST">

<div class="input-group">
<label>Nama Lengkap</label>
<input type="text" name="nama" required>
</div>

<div class="input-group">
<label>Email</label>
<input type="email" name="email" required>
</div>

<div class="input-group">
<label>No HP</label>
<input type="text" name="no_hp" required>
</div>

<div class="input-group">
<label>Password</label>
<div style="position: relative; display: flex; align-items: center;">
    <input type="password" name="password" id="regPassword" required style="padding-right: 40px; width: 100%;">
    <i class="fa-solid fa-eye" id="toggleRegPassword" style="position: absolute; right: 15px; cursor: pointer; color: #666;"></i>
</div>
</div>

<div class="input-group">
<label>Konfirmasi Password</label>
<div style="position: relative; display: flex; align-items: center;">
    <input type="password" name="konfirmasi" id="confirmPassword" required style="padding-right: 40px; width: 100%;">
    <i class="fa-solid fa-eye" id="toggleConfirmPassword" style="position: absolute; right: 15px; cursor: pointer; color: #666;"></i>
</div>
</div>

<button type="submit" class="btn">
DAFTAR
</button>

</form>

<p class="text-center" style="margin-top:20px;">

Sudah punya akun?

<a href="login.php" class="link">
Login
</a>

</p>

</div>

</div>

<script>
// Fungsi reusable untuk toggle password
function setupPasswordToggle(inputSelector, iSelector) {
    const toggleIcon = document.querySelector(iSelector);
    const passwordInput = document.querySelector(inputSelector);

    toggleIcon.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
}

// Jalankan untuk password utama & konfirmasi
setupPasswordToggle('#regPassword', '#toggleRegPassword');
setupPasswordToggle('#confirmPassword', '#toggleConfirmPassword');
</script>

<?php include '../layout/footer.php'; ?>