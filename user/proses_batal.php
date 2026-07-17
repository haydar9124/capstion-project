<?php
include '../config/session_user.php';
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id_pesanan = mysqli_real_escape_string($conn, $_GET['id']);
    $id_user = $_SESSION['id_user'];

    // 1. Cek apakah pesanan memang milik user tersebut dan statusnya masih bisa dibatalkan
    $cek = mysqli_query($conn, "SELECT status FROM pesanan WHERE id_pesanan='$id_pesanan' AND id_user='$id_user'");
    
    if (mysqli_num_rows($cek) > 0) {
        $row = mysqli_fetch_assoc($cek);
        $status_sekarang = $row['status'];

        // Pembatalan instan hanya boleh jika pesanan belum dikirim/selesai (Menunggu Pembayaran atau Diproses)
        if ($status_sekarang == "Menunggu Pembayaran" || $status_sekarang == "Diproses") {
            
            // 2. LANGSUNG UBAH STATUS JADI DIBATALKAN
            $update = mysqli_query($conn, "UPDATE pesanan SET status = 'Dibatalkan' WHERE id_pesanan = '$id_pesanan'");

            if ($update) {
                // 3. OTOMATIS KEMBALIKAN STOK BARANG KE GUDANG/PRODUK
                $detail = mysqli_query($conn, "SELECT id_produk, qty FROM detail_pesanan WHERE id_pesanan='$id_pesanan'");
                while ($item = mysqli_fetch_assoc($detail)) {
                    $id_produk = $item['id_produk'];
                    $qty = $item['qty'];
                    
                    // Tambahkan kembali stoknya
                    mysqli_query($conn, "UPDATE produk SET stok = stok + $qty WHERE id_produk='$id_produk'");
                }

                echo "<script>
                    alert('Pesanan berhasil dibatalkan dan stok produk telah dikembalikan!');
                    window.location='pesanan.php';
                </script>";
            } else {
                echo "<script>
                    alert('Gagal membatalkan pesanan.');
                    window.location='pesanan.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Pesanan tidak dapat dibatalkan karena sedang dikirim atau sudah selesai.');
                window.location='pesanan.php';
            </script>";
        }
    } else {
        echo "<script>window.location='pesanan.php';</script>";
    }
} else {
    echo "<script>window.location='pesanan.php';</script>";
}
?>