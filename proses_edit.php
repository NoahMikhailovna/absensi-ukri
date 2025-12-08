<?php
include 'koneksi.php';

$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nama = isset($_POST['nama_mahasiswa']) ? trim($_POST['nama_mahasiswa']) : '';
$npm  = isset($_POST['npm']) ? trim($_POST['npm']) : '';
$kelas= isset($_POST['kelas']) ? trim($_POST['kelas']) : '';
$status = isset($_POST['status_kehadiran']) ? trim($_POST['status_kehadiran']) : '';
$old_file = isset($_POST['old_file']) ? trim($_POST['old_file']) : null;

if ($id <= 0 || $nama=='' || $npm=='' || $kelas=='' || $status=='') {
    die("Data tidak lengkap. <a href='index.php'>Kembali</a>");
}

// cek apakah upload baru
$nama_file_baru = null;
if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['bukti'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload error. Kode: " . $file['error']);
    }
    $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];
    if (!in_array($ekstensi, $allowed)) {
        die("Tipe file tidak diperbolehkan. Hanya jpg/jpeg/png.");
    }
    $nama_file_baru = time() . '-' . bin2hex(random_bytes(4)) . '.' . $ekstensi;
    $target_folder = 'bukti/';
    if (!is_dir($target_folder)) mkdir($target_folder, 0755, true);
    if (!move_uploaded_file($file['tmp_name'], $target_folder . $nama_file_baru)) {
        die("Gagal menyimpan file.");
    }
}

// Update DB
if ($nama_file_baru !== null) {
    // hapus file lama bila ada
    if (!empty($old_file) && file_exists('bukti/'.$old_file)) {
        @unlink('bukti/'.$old_file);
    }
    $query = "UPDATE absensi_ukri SET nama_mahasiswa = ?, npm = ?, kelas = ?, status_kehadiran = ?, bukti_foto = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssssi", $nama, $npm, $kelas, $status, $nama_file_baru, $id);
} else {
    $query = "UPDATE absensi_ukri SET nama_mahasiswa = ?, npm = ?, kelas = ?, status_kehadiran = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssi", $nama, $npm, $kelas, $status, $id);
}

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal update: " . $stmt->error;
}
$stmt->close();
$koneksi->close();