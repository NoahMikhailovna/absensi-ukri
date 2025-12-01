<?php
include 'koneksi.php';

// Ambil input aman
$nama = isset($_POST['nama_mahasiswa']) ? trim($_POST['nama_mahasiswa']) : '';
$npm  = isset($_POST['npm']) ? trim($_POST['npm']) : '';
$kelas = isset($_POST['kelas']) ? trim($_POST['kelas']) : '';
$status = isset($_POST['status_kehadiran']) ? trim($_POST['status_kehadiran']) : '';

// Validasi sederhana
if ($nama === '' || $npm === '' || $kelas === '' || $status === '') {
    die("Semua field (kecuali bukti) harus diisi. <a href='tambah.php'>Kembali</a>");
}

// Handle upload (opsional)
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

    // buat nama unik
    $nama_file_baru = time() . '-' . bin2hex(random_bytes(4)) . '.' . $ekstensi;
    $target_folder = 'bukti/';
    if (!is_dir($target_folder)) mkdir($target_folder, 0755, true);

    if (!move_uploaded_file($file['tmp_name'], $target_folder . $nama_file_baru)) {
        die("Gagal menyimpan file.");
    }
}

// Insert ke database (prepared)
$query = "INSERT INTO absensi_ukri (nama_mahasiswa, npm, kelas, status_kehadiran, bukti_foto) VALUES (?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query);
$foto_for_db = $nama_file_baru !== null ? $nama_file_baru : null;
$stmt->bind_param("sssss", $nama, $npm, $kelas, $status, $foto_for_db);
if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menyimpan: " . $stmt->error;
}
$stmt->close();
$koneksi->close();