<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['transaksi_terakhir'])) {
    header("Location: dashboard.php");
    exit;
}

$data = $_SESSION['transaksi_terakhir'];
$id_transaksi = $data['id_transaksi'];

include 'config/koneksi.php';

// Ambil data transaksi penjualan (total & tanggal)
$transaksi = $koneksi->query("
    SELECT total, tanggal, id_kasir
    FROM transaksi
    WHERE id = $id_transaksi
")->fetch_assoc();

$total_harga = $transaksi['total'];
$tanggal = $transaksi['tanggal'];

// Ambil detail transaksi (item-item yang dibeli)
$detail = $koneksi->query("
    SELECT d.id_barang, d.jumlah, d.subtotal, b.nama
    FROM detail_transaksi d
    JOIN barang b ON d.id_barang = b.id
    WHERE d.id_transaksi = $id_transaksi
");

$nomor_kontak = '0812345678910';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - ServisKit</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; }
        body { background:#d32f2f; min-height:100vh; display:flex; flex-direction:column; align-items:center; padding:0; }
        .header-top { width:100%; background:#d32f2f; color:white; text-align:center; padding:15px 0; font-size:20px; font-weight:bold; }
        .header-bottom { width:100%; background:white; display:flex; justify-content:space-between; align-items:center; padding:10px 20px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
        .header-bottom .left { font-size:24px; font-weight:bold; color:red; }
        .header-bottom .right { font-size:18px; color:red; font-weight:bold; }
        .receipt-container {
            margin-top:30px; width:100%; max-width:500px; padding:20px;
            background:white; border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.1); text-align:center;
        }
        .receipt-header { font-size:22px; font-weight:bold; margin-bottom:10px; color:#333; }
        .total-price { font-size:32px; font-weight:bold; color:#d32f2f; margin:15px 0; }
        .items-list { text-align:left; margin:20px 0; padding:0 10px; }
        .items-list li { display:flex; justify-content:space-between; padding:5px 0; border-bottom:1px dashed #ccc; }
        .item-name { flex:2; }
        .item-qty-price { flex:1; text-align:right; }
        .total-row { display:flex; justify-content:space-between; font-weight:bold; margin-top:15px; padding-top:10px; border-top:2px solid #333; }
        .footer-note { margin-top:25px; font-size:14px; color:#666; line-height:1.5; text-align:center; }
        .btn-row { display:flex; justify-content:space-between; gap:10px; margin-top:25px; }
        .btn-row button {
            padding:10px 20px; background:#333; color:white; border:none; border-radius:5px;
            cursor:pointer; font-size:16px; flex:1; min-width:100px;
        }
        .btn-row button:hover { background:#555; }
        @media print {
            body { background:white; padding:20px; }
            .header-top, .header-bottom, .btn-row { display:none; }
            .receipt-container { box-shadow:none; border:1px solid #ccc; padding:30px; max-width:600px; }
            .total-price { font-size:36px; }
            .footer-note { font-size:12px; }
        }
    </style>
</head>
<body>
    <div class="header-top">Selamat Datang</div>
    <div class="header-bottom">
        <div class="left">ServisKit</div>
        <div class="right">Selalu menyediakan sparepart yang anda butuhkan</div>
    </div>

    <div class="receipt-container">
        <div class="receipt-header">ServisKit</div>
        <div class="total-price">Rp <?= number_format($total_harga, 0, ',', '.') ?></div>

        <ul class="items-list">
            <?php while($item = $detail->fetch_assoc()): ?>
            <li>
                <span class="item-name"><?= htmlspecialchars($item['nama']) ?></span>
                <span class="item-qty-price">
                    <?= $item['jumlah'] ?> x Rp <?= number_format($item['subtotal'] / $item['jumlah'], 0, ',', '.') ?>
                </span>
            </li>
            <?php endwhile; ?>
        </ul>

        <div class="total-row">
            <span>Total Harga</span>
            <span>Rp <?= number_format($total_harga, 0, ',', '.') ?></span>
        </div>

        <div class="footer-note">
            Terima kasih sudah servis disini<br>
            Kasir: <?= htmlspecialchars($data['nama_kasir']) ?><br>
            Silahkan hubungi: <strong><?= $nomor_kontak ?></strong><br>
            <?= date('d F Y H:i:s', strtotime($tanggal)) ?>
        </div>

        <div class="btn-row">
            <button onclick="window.print()">🖨️ Cetak</button>
            <button onclick="window.location.href='dashboard.php'">✅ Selesai</button>
        </div>
    </div>
</body>
</html>