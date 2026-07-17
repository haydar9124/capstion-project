<?php

include '../../config/session_admin.php';
include '../../config/koneksi.php';

// Mengamankan input ID dari SQL Injection
$id = mysqli_real_escape_string($conn, $_GET['id']);

$pesanan = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT 
            pesanan.*, 
            users.nama 
        FROM pesanan 
        JOIN users 
        ON pesanan.id_user=users.id_user 
        WHERE pesanan.id_pesanan='$id'"
    )
);

$detail = mysqli_query(
    $conn,
    "SELECT 
        detail_pesanan.*, 
        produk.nama_produk 
    FROM detail_pesanan 
    JOIN produk 
    ON detail_pesanan.id_produk=produk.id_produk 
    WHERE detail_pesanan.id_pesanan='$id'"
);

$judul = "Detail Pesanan";
$back_url = "index.php";

include '../../layout/header_admin.php';
include '../../layout/page_header_admin.php';

?>

<div class="page-content">

    <div class="card">
        <h2>Pesanan #<?= htmlspecialchars($pesanan['id_pesanan'] ?? ''); ?></h2>
        <br>
        <p>
            <b>Pelanggan</b>
            <br>
            <?= htmlspecialchars($pesanan['nama'] ?? ''); ?>
        </p>
        <br>
        <p>
            <b>Metode Pembayaran</b>
            <br>
            <?= htmlspecialchars($pesanan['metode_pembayaran'] ?? ''); ?>
        </p>
        <br>
        <p>
            <b>Status Saat Ini</b>
            <br>
            <span style="color:#ef4b2f;font-weight:bold;">
                <?= htmlspecialchars($pesanan['status'] ?? ''); ?>
            </span>
        </p>
    </div>

    <div class="card">
        <h3>Produk Yang Dibeli</h3>
        <hr>
        <?php while ($row = mysqli_fetch_assoc($detail)) { ?>
            <div style="margin-top:15px;">
                <b><?= htmlspecialchars($row['nama_produk']); ?></b>
                <br>
                Qty : <?= $row['qty']; ?>
                <br>
                Harga : Rp <?= number_format($row['harga']); ?>
                <br>
                Subtotal : Rp <?= number_format($row['subtotal']); ?>
            </div>
            <hr>
        <?php } ?>
        
        <h3 style="color:#ef4b2f;">
            Total
            <br>
            Rp <?= number_format($pesanan['total'] ?? 0); ?>
        </h3>
    </div>

    <div class="card">
        <form action="update_status.php" method="POST">
            <br>
          <a href="invoice.php?id=<?= urlencode($pesanan['id_pesanan']); ?>" target="_blank" class="btn-primary">

    <i class="fa-solid fa-print"></i>

    Cetak Invoice

</a>
            
            <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($pesanan['id_pesanan'] ?? ''); ?>">
            
            <br><br>
            <label>Status Pesanan</label>
            <select name="status" required>
                <?php
                $status = [
                    "Menunggu Pembayaran",
                    "Diproses",
                    "Dikirim",
                    "Selesai",
                    "Dibatalkan"
                ];

                foreach ($status as $s) {
                    $selected = ($pesanan['status'] == $s) ? 'selected' : '';
                    echo "<option value=\"$s\" $selected>$s</option>";
                }
                ?>
            </select>

            <button type="submit" class="btn-success">
                Update Status
            </button>
        </form>
    </div>

</div> </body>
</html>