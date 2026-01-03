<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';
include 'data.php'; // basis pengetahuan

// Ambil & validasi data
$nama   = $_POST['nama'] ?? $_SESSION['user'];
$usia   = isset($_POST['usia']) ? (int)$_POST['usia'] : 0;
$gejala_input = $_POST['gejala'] ?? [];

if ($usia <= 0 || empty($gejala_input)) {
    die("Data diagnosa tidak lengkap.");
}

// Proses diagnosa
$hasil = [];
foreach ($penyakit as $nama_penyakit => $gejala_penyakit) {
    $cocok = count(array_intersect($gejala_input, $gejala_penyakit));
    $total = count($gejala_penyakit);
    $persentase = ($total > 0) ? ($cocok / $total) * 100 : 0;

    if ($persentase > 0) {
        $hasil[$nama_penyakit] = $persentase;
    }
}

// Tentukan penyakit tertinggi
$penyakit_tertinggi = "-";
$persentase_tertinggi = 0;

if (!empty($hasil)) {
    arsort($hasil);
    $penyakit_tertinggi = key($hasil);
    $persentase_tertinggi = current($hasil);
}

// Simpan ke database
$gejala_string = implode(", ", $gejala_input);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO diagnosa (username, usia, gejala, hasil, persentase) VALUES (?, ?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "sissd",
    $nama,
    $usia,
    $gejala_string,
    $penyakit_tertinggi,
    $persentase_tertinggi
);

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasil Diagnosa GERD</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">

    <!-- Header -->
    <div style="text-align:center; margin-bottom:20px;">
        <img src="img/logo rs_nova.jpg" alt="RS Nova Care" style="max-width:100px;">
        <h3 style="margin:5px 0; color:#2c3e50;">RS ARSY CARE</h3>
        <p style="margin:0; color:#7f8c8d; font-style:italic;">Smart Care for Better Life</p>
    </div>

    <h2 style="text-align:center; color:#e67e22;">Hasil Diagnosa</h2>

    <!-- Info Pasien -->
    <div class="box">
        <p><b>Nama Pasien:</b> <?= htmlspecialchars($nama) ?></p>
        <p><b>Usia Pasien:</b> <?= $usia ?> tahun</p>

        <?php if ($usia <= 12): ?>
            <p style="color:#c0392b;"><i>Perlu perhatian khusus dari orang tua.</i></p>
        <?php else: ?>
            <p style="color:#27ae60;"><i>Disarankan menjaga pola makan & gaya hidup.</i></p>
        <?php endif; ?>
    </div>

    <!-- Hasil -->
    <div class="box hasil">
        <?php if (!empty($hasil)): ?>
            <?php foreach ($hasil as $penyakit_nama => $persen): ?>
                <p>
                    <b><?= $penyakit_nama ?></b>  
                    <span style="color:#e67e22;">
                        (<?= round($persen, 2) ?>%)
                    </span>
                </p>
            <?php endforeach; ?>

            <?php if (isset($penyemangat[$penyakit_tertinggi])): ?>
                <p style="font-style:italic; color:#2980b9;">
                    <?= $penyemangat[$penyakit_tertinggi] ?>
                </p>
            <?php endif; ?>
        <?php else: ?>
            <p>Tidak ditemukan kecocokan gejala.</p>
        <?php endif; ?>
    </div>

    <!-- Saran -->
    <button id="btnSaran">Lihat Saran Makanan</button>
    <div id="saran" style="display:none;">
        <h3>Rekomendasi Makanan & Minuman</h3>

        <?php if (isset($rekomendasi[$penyakit_tertinggi])): ?>
            <?php foreach ($rekomendasi[$penyakit_tertinggi] as $waktu => $list): ?>
                <h4><?= $waktu ?></h4>
                <ul>
                    <?php foreach ($list as $item): ?>
                        <li><?= htmlspecialchars($item) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Cetak -->
    <div style="text-align:center; margin-top:20px;">
        <button onclick="window.print()">Cetak Hasil (PDF)</button>
    </div>

</div>

<script>
document.getElementById('btnSaran').addEventListener('click', function () {
    document.getElementById('saran').style.display = 'block';
    this.style.display = 'none';
});
</script>

</body>
</html>
