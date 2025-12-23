<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bikin Motor Beda - ServisKit</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">"
</head>
<body>
    <div class="header">
        <h1>Bikin Motor Beda</h1>
        <a href="login.php" class="login-btn">LOGIN</a>
    </div>

    <div class="banner">
        Stop pusing cari yang pasti! Kami menyediakan sparepart dengan mutu teruji
    </div>

    <div class="content">
        <div class="left-content">
            <h2>ServisKit</h2>
            <p>Paket perawatan rutin pada kendaraan anda yang berisi komponen dan perlengkapan dasar pada kendaraan anda yang biasanya mencakup ganti oli, filter oli, filter udara, ganti busi, kampas rem, dll.</p>
        </div>
        <div class="right-content">
            <img src="assets/images/log.jpeg" alt="Mekanik Sedang Bekerja">
        </div>
    </div>

    <div class="footer">
        Hubungi Kami: +1234 567890
    </div>
</body>
</html>