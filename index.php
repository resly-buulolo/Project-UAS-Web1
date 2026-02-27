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
    <link rel="stylesheet" href="style.css">
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
