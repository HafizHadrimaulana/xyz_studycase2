<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip        = $_POST['nip'];
    $nama       = $_POST['nama'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $unit       = $_POST['unit'];
    $jabatan    = $_POST['jabatan'];
    $status     = $_POST['status'];
    $tgl_masuk  = $_POST['tgl_masuk'];
    $tgl_keluar  = $_POST['tgl_keluar'];
        if (empty($tgl_keluar)) {
        $tgl_keluar = null;
    }
    $pendidikan = $_POST['pendidikan'];
    $pelatihan  = $_POST['pelatihan'];
    $email      = $_POST['email'];

    $stmt = $pdo->prepare("INSERT INTO pegawai 
        (NIP, Nama_Pegawai, Tgl_Lahir, Unit_Kerja, Jabatan, Tgl_Masuk, Tgl_Keluar, Status, Pendidikan, Pelatihan_Wajib, Email_Kerja)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $nip, $nama, $tgl_lahir, $unit, $jabatan,
        $tgl_masuk, $tgl_keluar, $status, $pendidikan, $pelatihan, $email
    ]);

    header("Location: employees.php?added=1");
    exit;
}
?>
