<?php
session_start();
include 'koneksi.php';

$error = "";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email == "" || $password == "") {
        $error = "Email dan password wajib diisi.";
    } else {

        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {

            // Password masih plain text (sesuai punyamu)
            if ($password === $row['password']) {

                $_SESSION['email'] = $row['email'];
                $_SESSION['name']  = $row['name'];
                $_SESSION['role']  = $row['role'];
                $_SESSION['login']  = true;

                header("Location: dashboard.php");
                exit;

            } else {
                $error = "Password salah.";
            }

        } else {
            $error = "Email tidak ditemukan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | POLGAN MART</title>
    <style>
        /* Reset sederhana */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f4f6f8;
        }

        .login-card {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 360px;
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 20px;
            color: #34495e;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #3498db;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #3498db;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-reset {
            width: 100%;
            padding: 10px;
            background: #e74c3c;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-reset:hover {
            background: #c0392b;
        }

        .error {
            background: #e74c3c;
            color: white;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #95a5a6;
        }
    </style>
</head>
<body>

<div class="login-card">
    <h2>POLGAN MART</h2>

    <?php if ($error != "") : ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email anda" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn">Login</button>
        <button type="reset" class="btn-reset">Batal</button>
    </form>

    <div class="footer">
        © 2026 POLGAN MART
    </div>
</div>

</body>
</html>