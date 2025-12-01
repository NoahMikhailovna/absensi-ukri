<?php
include 'koneksi.php';
if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = intval($_GET['id']);

// ambil nama file dulu
$stmt = $koneksi->prepare("SELECT bukti_foto FROM absensi_ukri WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();
$stmt->close();
if (!$data) { die("Data tidak ditemukan."); }

// hapus file fisik jika ada
if (!empty($data['bukti_foto']) && file_exists('bukti/'.$data['bukti_foto'])) {
    @unlink('bukti/'.$data['bukti_foto']);
}

// hapus record
$stmt2 = $koneksi->prepare("DELETE FROM absensi_ukri WHERE id = ?");
$stmt2->bind_param("i", $id);
if ($stmt2->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal hapus: " . $stmt2->error;
}
$stmt2->close();
$koneksi->close();