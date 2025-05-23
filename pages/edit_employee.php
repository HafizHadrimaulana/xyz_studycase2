<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

if (!isset($_GET['nip'])) {
    header("Location: employees.php");
    exit;
}

$nip = $_GET['nip'];
$stmt = $pdo->prepare("SELECT * FROM pegawai WHERE NIP = ?");
$stmt->execute([$nip]);
$pegawai = $stmt->fetch();

if (!$pegawai) {
    echo "Data tidak ditemukan.";
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = $_POST['nama'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $unit       = $_POST['unit'];
    $jabatan    = $_POST['jabatan'];
    $status     = $_POST['status'];
    $tgl_masuk  = $_POST['tgl_masuk'];
    $tgl_keluar = $_POST['tgl_keluar'];  // Tambahan
        if (empty($tgl_keluar)) {
        $tgl_keluar = null;
    }
    $pendidikan = $_POST['pendidikan'];
    $pelatihan  = $_POST['pelatihan'];
    $email      = $_POST['email'];

    $update = $pdo->prepare("UPDATE pegawai SET 
        Nama_Pegawai=?, Tgl_Lahir=?, Unit_Kerja=?, Jabatan=?, Status=?, Tgl_Masuk=?, Tgl_Keluar=?, Pendidikan=?, Pelatihan_Wajib=?, Email_Kerja=? 
        WHERE NIP=?");
    $update->execute([
        $nama, $tgl_lahir, $unit, $jabatan, $status, $tgl_masuk, $tgl_keluar, $pendidikan, $pelatihan, $email, $nip
    ]);

    header("Location: employees.php?updated=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Karyawan</title>
    <!-- Bootstrap & AdminLTE -->
    <link rel="stylesheet" href="/xyz_studycase2/assets/vendor/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/xyz_studycase2/assets/vendor/adminlte/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/xyz_studycase2/assets/vendor/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Header & Sidebar -->
    <?php require_once '../includes/header.php'; ?>
    <?php require_once '../includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Edit Data Karyawan</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIP</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($pegawai['NIP']) ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Pegawai</label>
                                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($pegawai['Nama_Pegawai']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir" class="form-control" value="<?= date('Y-m-d', strtotime($pegawai['Tgl_Lahir'])) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit Kerja</label>
                                        <input type="text" name="unit" class="form-control" value="<?= htmlspecialchars($pegawai['Unit_Kerja']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="<?= htmlspecialchars($pegawai['Jabatan']) ?>" required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="Tetap" <?= $pegawai['Status'] === 'Tetap' ? 'selected' : '' ?>>Tetap</option>
                                            <option value="Kontrak" <?= $pegawai['Status'] === 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" name="tgl_masuk" class="form-control" value="<?= date('Y-m-d', strtotime($pegawai['Tgl_Masuk'])) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Keluar</label>
                                        <input type="date" name="tgl_keluar" class="form-control" value="<?= $pegawai['Tgl_Keluar'] ? date('Y-m-d', strtotime($pegawai['Tgl_Keluar'])) : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Pendidikan</label>
                                        <input type="text" name="pendidikan" class="form-control" value="<?= htmlspecialchars($pegawai['Pendidikan']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Pelatihan Wajib</label>
                                        <input type="text" name="pelatihan" class="form-control" value="<?= htmlspecialchars($pegawai['Pelatihan_Wajib']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email Kerja</label>
                                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($pegawai['Email_Kerja']) ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                <a href="employees.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php require_once '../includes/footer.php'; ?>
</div>

<!-- JS -->
<script src="/xyz_studycase2/assets/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/xyz_studycase2/assets/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/xyz_studycase2/assets/vendor/adminlte/dist/js/adminlte.min.js"></script>
</body>
</html>
