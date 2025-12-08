<?php 
include "koneksi.php";

// --- PENCARIAN ---
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

if($cari != "") {
    $stmt = $koneksi->prepare("SELECT * FROM absensi_ukri 
                               WHERE nama_mahasiswa LIKE ? OR npm LIKE ?
                               ORDER BY id ASC");
    $like = "%".$cari."%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("SELECT * FROM absensi_ukri ORDER BY id ASC");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Absensi UKRI</title>

<style>

/* ====== GLOBAL ====== */
body {
    margin: 0;
    padding: 0;
    font-family: "Poppins", sans-serif;
    background: #f4f6f8;
    color: #333;
}

/* ====== NAVBAR ====== */
.navbar {
    background: #fff;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    position: sticky;
    top: 0;
}
.navbar h2 {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}
.navbar a {
    text-decoration: none;
    padding: 10px 18px;
    background: #2c3e50;
    color: white;
    border-radius: 6px;
}
.navbar a:hover { background: #1a242f; }

/* ====== CONTAINER ====== */
.container {
    width: 90%;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

/* ====== TABLE WRAPPER ====== */
.table-wrapper {
    overflow-x: auto;
    margin-top: 20px;
    border-radius: 10px;
}

/* ====== TABLE ====== */
table {
    width: 100%;
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 0 8px;
}
table th {
    background: #2c3e50;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
}
table td {
    background: #fff;
    padding: 12px;
    border-bottom: 1px solid #eee;
}
table tr:hover td { background: #f7f9fc; }

/* COLUMN WIDTH */
table th:nth-child(1), table td:nth-child(1) { width: 50px; }
table th:nth-child(2), table td:nth-child(2) { width: 180px; }
table th:nth-child(3), table td:nth-child(3) { width: 120px; }
table th:nth-child(4), table td:nth-child(4) { width: 70px; }
table th:nth-child(5), table td:nth-child(5) { width: 120px; }
table th:nth-child(6), table td:nth-child(6) { width: 120px; text-align: center; }
table th:nth-child(7), table td:nth-child(7) { width: 200px; }

/* IMAGE THUMB */
.img-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #ddd;
}

/* BUTTON */
.btn {
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    color: white;
}
.btn-view { background: #3498db; }
.btn-edit { background: #f39c12; }
.btn-del  { background: #ff1900ff; }
.btn:hover { opacity: 0.8; }

</style>

</head>
<body>

<div class="navbar">
    <h2>Absensi Mahasiswa UKRI</h2>
    <a href="tambah.php">+ Tambah Data</a>
</div>

<div class="container">
    <h3>Daftar Absensi</h3>

    <!-- ===== SEARCH BAR ===== -->
    <form method="GET" style="margin-top: 15px; display:flex; gap:10px;">
        <input type="text" name="cari" placeholder="Cari nama atau NPM..."
               value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>"
               style="padding:10px; width:250px; border-radius:6px; border:1px solid #ccc;">
        
        <button type="submit" 
            style="padding:10px 18px; background:#2c3e50; color:white; border:none; border-radius:6px;">
            Cari
        </button>

        <a href="index.php" 
           style="padding:10px 18px; background:#888; color:white; border-radius:6px; text-decoration:none;">
           Reset
        </a>
    </form>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NPM</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>

            <?php 
            $no = 1;
            while($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_mahasiswa']; ?></td>
                <td><?= $row['npm']; ?></td>
                <td><?= $row['kelas']; ?></td>
                <td><?= $row['status_kehadiran']; ?></td>
                <td>
                    <?php if($row['bukti_foto']) { ?>
                        <img src="bukti/<?= $row['bukti_foto']; ?>" class="img-thumb">
                    <?php } else { echo "-"; } ?>
                </td>
                <td>
                    <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-view">View</a>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" 
                       onclick="return confirm('Hapus data ini?')"
                       class="btn btn-del">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>