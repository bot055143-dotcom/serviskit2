<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'config/koneksi.php';
$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
$barang_list = $koneksi->query("SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang - ServisKit</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="header">
        <h1>ServisKit</h1>
        <span>Selalu menyediakan sparepart yang anda butuhkan</span>
    </div>

    <div class="dashboard-container">
        <h2>Selamat Datang, <?= htmlspecialchars($nama) ?>!</h2>

        <form method="POST" action="
            <?php 
            if ($role == 'staff_gudang') echo 'stok_masuk.php';
            elseif ($role == 'kasir') echo 'transaksi.php';
            else echo 'barang.php';
            ?>
        ">
            <label>Id_Barang</label>
            <select name="id_barang" required>
                <option value="">-- Pilih Barang --</option>
                <?php while($b = $barang_list->fetch_assoc()): ?>
                <option value="<?= $b['id'] ?>"><?= $b['nama'] ?> (Stok: <?= $b['stok'] ?>)</option>
                <?php endwhile; ?>
            </select><br>

            <label>Jumlah_Barang</label>
            <input type="number" name="jumlah_barang" min="1" placeholder="Value" required><br>

            <div class="btn-row">
                <button type="submit" name="action" value="batal">Batal</button>
                <button type="submit" name="action" value="tambah">Tambah</button>
                <button type="submit" name="action" value="selesai">Selesai</button>
            </div>
            <div class="btn-row">
                <button type="button" onclick="alert('Fitur pencarian belum diimplementasikan')">Pencarian</button>
                <button type="button" onclick="window.location.href='laporan_stok.php'">Laporan</button>
            </div>
        </form>

        <div style="margin-top: 20px; text-align: left;">
            <h3>Menu:</h3>
            <?php if ($role == 'admin'): ?>
                <a href="barang.php">Kelola Data Barang</a><br>
                <a href="laporan_keuangan.php">Laporan Keuangan</a><br>
                <a href="laporan_stok.php">Laporan Stok</a><br>
                <a href="logout.php">Logout</a>
            <?php elseif ($role == 'kasir'): ?>
                <a href="transaksi.php">Transaksi Penjualan</a><br>
                <a href="return.php">Return Barang</a><br>
                <a href="logout.php">Logout</a>
            <?php elseif ($role == 'staff_gudang'): ?>
                <a href="stok_masuk.php">Stok Masuk</a><br>
                <a href="stok_keluar.php">Stok Keluar</a><br>
                <a href="laporan_stok.php">Laporan Stok</a><br>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        Hubungi Kami: +1234 567890
    </div>
</body>
</html>