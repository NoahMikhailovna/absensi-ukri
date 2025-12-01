<?php
include 'koneksi.php';
$id = $_GET['id'];

$q = $koneksi->prepare("SELECT * FROM absensi_ukri WHERE id=?");
$q->bind_param("i", $id);
$q->execute();
$data = $q->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Absensi</title>
    <style>
        body {
            font-family: Arial;
            background:#fafafa;
            margin:0;
            padding:30px;
        }
        .container {
            max-width: 480px;
            margin:auto;
            background:#fff;
            padding:40px;
            border:1px solid #eee;
            border-radius:10px;
        }
        h2 {
            margin-top:0;
        }
        input, select {
            width:100%;
            padding:10px;
            margin:8px 0 15px;
            border:1px solid #ccc;
            border-radius:6px;
        }
        label {
            font-size:14px;
            font-weight:600;
        }
        img {
            max-width:150px;
            margin-top:10px;
            border-radius:6px;
            border:1px solid #ddd;
        }
        button {
            padding:10px 15px;
            border:none;
            border-radius:6px;
            background:#333;
            color:white;
            cursor:pointer;
        }
        button:hover {
            background:#000;
        }
        a {
            font-size:14px;
            text-decoration:none;
            color:#444;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2><center>Edit Absensi</center></h2>

        <form action="proses_edit.php" method="post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="hidden" name="old_file" value="<?= $data['bukti_foto'] ?>">

            <label>Nama Mahasiswa</label>
            <input type="text" name="nama_mahasiswa" value="<?= $data['nama_mahasiswa'] ?>" required>

            <label>NPM</label>
            <input type="text" name="npm" value="<?= $data['npm'] ?>" required>

            <label>Kelas</label>
            <input type="text" name="kelas" value="<?= $data['kelas'] ?>" required>

            <label>Status Kehadiran</label>
            <select name="status_kehadiran">
                <option <?= $data['status_kehadiran']=='Hadir'?'selected':'' ?>>Hadir</option>
                <option <?= $data['status_kehadiran']=='Sakit'?'selected':'' ?>>Sakit</option>
                <option <?= $data['status_kehadiran']=='Izin'?'selected':'' ?>>Izin</option>
            </select>

            <label>Bukti Foto Saat Ini</label><br>

            <?php if($data['bukti_foto']): ?>
                <img src="bukti/<?= $data['bukti_foto'] ?>">
            <?php else: ?>
                <p style="color:#777;">Tidak ada foto</p>
            <?php endif; ?>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png">

            <button type="submit">Simpan</button>
            &nbsp;&nbsp;
            <a href="index.php">Kembali</a>

        </form>
    </div>

</body>
</html>