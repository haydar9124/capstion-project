<?php

include '../config/session_user.php';
include '../config/koneksi.php';

// 1. Tangkap kata kunci pencarian jika ada
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// 2. Modifikasi query produk terbaru berdasarkan pencarian
if (!empty($search)) {
    // Jika ada pencarian, cari produk yang namanya mirip (LIKE)
    $produk_terbaru = mysqli_query($conn, "
        SELECT * FROM produk 
        WHERE nama_produk LIKE '%$search%'
        ORDER BY id_produk DESC
    ");
} else {
    // Jika tidak ada pencarian, tampilkan default 4 produk terbaru
    $produk_terbaru = mysqli_query($conn, "
        SELECT * FROM produk 
        ORDER BY id_produk DESC 
        LIMIT 4
    ");
}

$total_produk = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM produk")
);

$total_pesanan = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM pesanan 
        WHERE id_user='" . $_SESSION['id_user'] . "'
    ")
);

include '../layout/header_user.php';

?>

<div class="container">

    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-title">
                E-Warung
            </span>
        </div>
        <i class="fa-solid fa-store"></i>
    </div>

    <div class="page-content">

        <div class="card" style="text-align:center;">
            <h2>Selamat Datang</h2>
            <p><?= htmlspecialchars($_SESSION['nama']); ?></p>
        </div>

        <div class="card" style="padding: 12px;">
            <form action="" method="GET" style="display: flex; gap: 6px; align-items: center; width: 100%;">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari produk..." 
                    value="<?= htmlspecialchars($search); ?>"
                    style="flex: 1; min-width: 0; padding: 10px 12px; border: 1px solid #ccc; border-radius: 8px; outline: none; font-size: 14px; -webkit-appearance: none;"
                >
                <button 
                    type="submit" 
                    class="btn-primary" 
                    style="padding: 10px 14px; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap; flex-shrink: 0; font-size: 14px; width: auto;"
                >
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <?php if (!empty($search)): ?>
                    <a href="<?= $_SERVER['PHP_SELF']; ?>" style="padding: 10px 12px; border-radius: 8px; background: #6c757d; color: white; text-decoration: none; display: inline-flex; align-items: center; white-space: nowrap; flex-shrink: 0; font-size: 14px; height: 38px; box-sizing: border-box;">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="card">
            <h3>E-Warung</h3>
            <p>Platform belanja online sederhana untuk memenuhi kebutuhan sehari-hari.</p>
        </div>

        <div class="card">
            <p>Total Produk</p>
            <h2 style="color:#ef4b2f;"><?= $total_produk ?></h2>
        </div>

        <div class="card">
            <p>Pesanan Saya</p>
            <h2 style="color:#ef4b2f;"><?= $total_pesanan ?></h2>
        </div>

        <h3 style="margin-bottom:15px;">
            <?= !empty($search) ? 'Hasil Pencarian: "' . htmlspecialchars($search) . '"' : 'Produk Terbaru'; ?>
        </h3>

        <?php if (mysqli_num_rows($produk_terbaru) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($produk_terbaru)): ?>
                <div class="card">
                    <?php if (!empty($row['foto'])) { ?>
                        <img src="../assets/uploads/<?= $row['foto']; ?>" style="width:100%; height:160px; object-fit:cover; border-radius:12px; margin-bottom:10px;">
                    <?php } ?>

                    <h4><?= htmlspecialchars($row['nama_produk']); ?></h4>
                    <p style="color:#ef4b2f;">Rp <?= number_format($row['harga']); ?></p>
                    <br>
                    <a href="detail_produk.php?id=<?= $row['id_produk']; ?>" class="btn-primary">
                        Lihat Detail
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="card" style="text-align: center; color: #666;">
                <p>Produk yang Anda cari tidak ditemukan.</p>
            </div>
        <?php endif; ?>

        <a href="produk.php" class="btn-primary" style="margin-top: 15px; display: inline-block;">
            Lihat Semua Produk
        </a>

    </div>

    <?php include '../layout/navbar_bottom.php'; ?>

</div>

</body>
</html>