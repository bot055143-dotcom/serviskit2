<?php
session_start();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $role = $_POST['role'];

    if (!empty($id_user) && !empty($username) && !empty($password) && !empty($nama) && !empty($role)) {
        $_SESSION['id_user'] = $id_user;
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $nama;
        $_SESSION['role'] = $role;

        if ($role === "kasir") {
            header("Location: Kasir/dashboard.php");
            exit;
        } elseif ($role === "admin") {
            header("Location: admin/index.php");
            exit;
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ServisKit</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('Assets/images/sparepart.jpeg') no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: white;
            margin: 0;
        }

        /* Overlay gelap tipis */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            z-index: -1;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            backdrop-filter: blur(6px);
        }

        .form-container h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            text-shadow: 0 0 2px rgba(0,0,0,0.1);
        }

        .error-message {
            background-color: #ffebee;
            color: #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
            border: 1px solid #ffcdd2;
            font-size: 14px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin: 15px 0 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            margin-bottom: 20px;
            background: #f9f9f9;
            font-style: italic;
        }

        .role-buttons {
            display: flex;
            justify-content: space-between;
            margin: 25px 0;
            gap: 10px;
        }

        .role-buttons button {
            flex: 1;
            padding: 12px;
            background-color: #222;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .role-buttons button:hover {
            background-color: #444;
        }

        .help-link {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: underline;
            font-size: 14px;
            cursor: pointer;
        }

        .help-link:hover {
            color: #0056b3;
        }

        /* Responsif */
        @media (max-width: 768px) {
            body {
                background-attachment: scroll;
                padding: 10px;
            }
            .form-container {
                padding: 20px;
                width: 95%;
            }
            .role-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Mohon Lakukan Verifikasi Terlebih Dahulu</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Id User</label>
            <input type="text" name="id_user" placeholder="Value" required>

            <label>Username</label>
            <input type="text" name="username" placeholder="Value" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Value" required>

            <label>Nama</label>
            <input type="text" name="nama" placeholder="Value" required>

            <div class="role-buttons">
                <button type="submit" name="role" value="kasir">Kasir</button>
                <button type="submit" name="role" value="admin">Admin</button>
            </div>

            <a href="#" class="help-link">Bantuan</a>
        </form>
    </div>
</body>
</html>