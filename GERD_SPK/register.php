<?php
session_start();
include 'akun.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(isset($akun[$username])){
        $error = "Username sudah digunakan!";
    } else {
        // Simulasi menambah akun baru (saat ini hanya array sementara)
        $akun[$username] = $password;
        $_SESSION['login'] = true;
        $_SESSION['user'] = $username;
        header("Location: diagnosa.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buat Akun Baru</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="register-container">
    <h2>Register Pasien GERD</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="register" value="Daftar">
    </form>
    <p>Sudah punya akun? <a href="index.php">Login disini</a></p>
</div>

</body>
</html>
