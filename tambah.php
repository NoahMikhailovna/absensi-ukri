<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Absensi</title>
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
            font-weight:600;
            letter-spacing:0.5px;
        }
        input, select {
            width:100%;
            padding:10px;
            margin:8px 0 15px;
            border:1px solid #ccc;
            border-radius:6px;
            font-size:14px;
        }
        label {
            font-size:14px;
            font-weight:600;
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
        <h2>Tambah Absensi</h2>

        <form action="proses_tambah.php" method="post" enctype="multipart/form-data">

            <label>Nama Mahasiswa</label>
            <input type="text" name="nama_mahasiswa" required>

            <label>NPM</label>
            <input type="text" name="npm" required>

            <label>Kelas</label>
            <input type="text" name="kelas" required>

            <label>Status Kehadiran</label>
            <select name="status_kehadiran" required>
                <option value="">Pilih</option>
                <option value="Hadir">Hadir</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
            </select>

            <label>Bukti Foto (optional)</label>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png">

            <button type="submit">Simpan</button>
            &nbsp;&nbsp;
            <a href="index.php">Kembali</a>

        </form>
    </div>

</body>
</html>