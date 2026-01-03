<?php
session_start();
include 'akun.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(isset($akun[$username]) && $akun[$username] == $password){
        $_SESSION['login'] = true;
        $_SESSION['user'] = $username;
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
<title>Login Sistem Pakar GERD</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-background">
    <div class="login-container">
        <h2>Login Pasien GERD</h2>
        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <p class="register-link">Belum punya akun? <a href="register.php">Buat Akun Baru</a></p>
    </div>
</div>
</body>
</html>
