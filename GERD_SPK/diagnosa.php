<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php'; // koneksi database
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa GERD</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h2>Konsultasi Pasien GERD</h2>

    <div class="chat-box">
        <p class="bot">
            Halo <b><?php echo htmlspecialchars($_SESSION['user']); ?></b> 👋  
            Silakan isi usia dan pilih gejala yang Anda rasakan.
        </p>
    </div>

    <!-- FORM DIAGNOSA -->
    <form action="hasil.php" method="post">

        <!-- Data Pasien -->
        <input type="hidden" name="nama" value="<?php echo htmlspecialchars($_SESSION['user']); ?>">

        <label><b>Usia Pasien</b></label>
        <input type="number" name="usia" min="1" placeholder="Masukkan usia pasien" required>

        <hr>

        <h3>Gejala Umum</h3>
        <div class="gejala-options">
            <label><input type="checkbox" name="gejala[]" value="Heartburn"> Rasa panas di dada (Heartburn)</label>
            <label><input type="checkbox" name="gejala[]" value="Mudah kenyang"> Mudah kenyang</label>
            <label><input type="checkbox" name="gejala[]" value="Sering bersendawa"> Sering bersendawa</label>
            <label><input type="checkbox" name="gejala[]" value="Sakit tenggorokan"> Sakit tenggorokan</label>
            <label><input type="checkbox" name="gejala[]" value="Batuk tanpa dahak"> Batuk tanpa dahak</label>
            <label><input type="checkbox" name="gejala[]" value="Bau mulut"> Bau mulut</label>
        </div>

        <h3>Gejala Anak-anak</h3>
        <div class="gejala-options">
            <label><input type="checkbox" name="gejala[]" value="Tersedak saat tidur"> Tersedak saat tidur</label>
            <label><input type="checkbox" name="gejala[]" value="Sulit tidur setelah makan"> Sulit tidur setelah makan</label>
            <label><input type="checkbox" name="gejala[]" value="Muntah kecil berulang"> Muntah kecil berulang</label>
            <label><input type="checkbox" name="gejala[]" value="Tenggorokan serak"> Tenggorokan serak</label>
            <label><input type="checkbox" name="gejala[]" value="Sulit bernapas"> Kesulitan bernapas</label>
        </div>

        <input type="submit" name="konsultasi" value="Konsultasi">

    </form>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
