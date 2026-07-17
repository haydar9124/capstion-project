<?php

include '../config/session_user.php';
include '../config/koneksi.php';

$judul = "Pesanan Saya";
$back_url = "dashboard.php";

include '../layout/header_user.php';

$data = mysqli_query($conn, "
    SELECT *
    FROM pesanan
    WHERE id_user='" . $_SESSION['id_user'] . "'
    ORDER BY tanggal DESC
");

?>

<div class="header-nav" style="background: #ef4b2f; padding: 15px; display: flex; align-items: center; position: sticky; top: 0; z-index: 999; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <a href="<?= $back_url; ?>" style="color: #ffffff; font-size: 18px; margin-right: 15px; text-decoration: none; display: flex; align-items: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h2 style="font-size: 16px; font-weight: 600; color: #ffffff; margin: 0; flex-grow: 1;">
        <?= $judul; ?>
    </h2>
</div>

<div class="container" style="padding-top: 15px; padding-bottom: 80px;">
    <div class="page-content">

        <?php if (mysqli_num_rows($data) == 0) { ?>
            <div class="card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                <h3 align="center" style="color: #888; font-weight: 400; font-size: 14px; padding: 20px 0;">
                    Belum ada pesanan.
                </h3>
            </div>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <div class="card" style="background: white; padding: 15px; border-radius: 12px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                
                <h3 style="font-size: 14px; color: #333; font-weight: 600;">
                    Invoice #<?= str_pad($row['id_pesanan'], 6, "0", STR_PAD_LEFT); ?>
                </h3>
                
                <hr style="margin: 10px 0; border: 0; border-top: 1px dashed #eee;">

                <p style="font-size: 12px; color: #666; margin-bottom: 6px;">
                    Tanggal: <b style="color: #333;"><?= date("d M Y H:i", strtotime($row['tanggal'])); ?></b>
                </p>

                <p style="font-size: 12px; color: #666;">
                    Status:
                    <?php
                    $status = $row['status'];
                    $warna = "#16a34a"; // Hijau

                    if ($status == "Menunggu Pembayaran") {
                        $warna = "#f59e0b"; // Oranye Kuning
                    } elseif ($status == "Diproses") {
                        $warna = "#2563eb"; // Biru
                    } elseif ($status == "Dikirim") {
                        $warna = "#9333ea"; // Ungu
                    } elseif ($status == "Dibatalkan") {
                        $warna = "#dc2626"; // Merah
                    }
                    ?>
                    <span style="display:inline-block; background:<?= $warna ?>; color:white; padding:3px 10px; border-radius:20px; font-size:11px; font-weight: 600; margin-left:5px;">
                        <?= $status ?>
                    </span>
                </p>

                <h2 style="color:#ef4b2f; font-size: 16px; margin-top: 10px; margin-bottom: 12px; font-weight: 600;">
                    Rp <?= number_format($row['total']); ?>
                </h2>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    
                    <a href="invoice.php?id=<?= $row['id_pesanan']; ?>" style="display: block; text-align: center; text-decoration: none; background: #ef4b2f; color: white; padding: 10px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Lihat Detail & Cetak Invoice
                    </a>

                    <?php if ($status == "Menunggu Pembayaran" || $status == "Diproses") { ?>
                        <a href="proses_batal.php?id=<?= $row['id_pesanan']; ?>" 
                           onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Stok barang akan otomatis dikembalikan.')" 
                           style="display: block; text-align: center; text-decoration: none; background: #fff; color: #dc2626; border: 1px solid #dc2626; padding: 9px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                            <i class="fa-solid fa-trash-can"></i> Batalkan Pesanan
                        </a>
                    <?php } ?>

                </div>

            </div>
        <?php } ?>

    </div>
</div>

<?php include '../layout/navbar_bottom.php'; ?>

</body>
</html>