<?php
include 'koneksi.php';
$id = $_GET['id'];

$q = $koneksi->prepare("SELECT * FROM absensi_ukri WHERE id=?");
$q->bind_param("i", $id);
$q->execute();
$data = $q->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Absensi</title>
    <style>
        body {
            font-family: Arial;
            background:#fafafa;
            padding:30px;
        }
        .box {
            max-width:420px;
            margin:auto;
            background:white;
            padding:25px;
            border:1px solid #eee;
            border-radius:10px;
        }
        img {
            max-width:250px;
            border-radius:8px;
            border:1px solid #ddd;
            margin-top:10px;
        }
        a {
            text-decoration:none;
            color:#444;
        }
        h2 {
            margin-top:0;
        }
        p {
            margin:6px 0;
        }
    </style>
</head>
<body>

    <div class="box">
        <h2><center>Detail Absensi</center></h2>

        <p><b>Nama:</b> <?= $data['nama_mahasiswa'] ?></p>
        <p><b>NPM:</b> <?= $data['npm'] ?></p>
        <p><b>Kelas:</b> <?= $data['kelas'] ?></p>
        <p><b>Status:</b> <?= $data['status_kehadiran'] ?></p>

        <b>Bukti Foto:</b><br>

        <?php if($data['bukti_foto']): ?>
            <img src="bukti/<?= $data['bukti_foto'] ?>">
        <?php else: ?>
            <p style="color:#777;">Tidak ada foto</p>
        <?php endif; ?>

        <br><br>
        <a href="index.php">Kembali</a>
    </div>

</body>
</html>