<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users 
                                  WHERE username='$username' 
                                  AND password='$password'");

    if (mysqli_num_rows($query) == 1) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['login'] = true;
        $_SESSION['user']  = $data['username'];
        header("Location: diagnosa.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Sistem Pakar GERD</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Login Pasien GERD</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>

    <p>Belum punya akun? <a href="register.php">Buat Akun Baru</a></p>
</div>

</body>
</html>
