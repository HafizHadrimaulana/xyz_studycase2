<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../includes/auth_check.php';
$pageTitle = 'Data Karyawan';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../config/database.php';

// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $nip = $_POST['nip'] ?? '';
    
    if (!empty($nip)) {
        try {
            $stmt = $pdo->prepare("DELETE FROM pegawai WHERE NIP = ?");
            $stmt->execute([$nip]);
            
            if ($stmt->rowCount() > 0) {
                $_SESSION['success_message'] = 'Data berhasil dihapus';
            } else {
                $_SESSION['error_message'] = 'Data tidak ditemukan';
            }
        } catch (PDOException $e) {
            $_SESSION['error_message'] = 'Error: ' . $e->getMessage();
        }
        
        // Redirect ke halaman ini lagi untuk menghindari resubmit form
        header("Location: employees.php");
        exit;
    }
}

// Inisialisasi filter
$where = [];
$params = [];

// Filter Status
if (isset($_GET['status']) && $_GET['status'] !== '' && in_array($_GET['status'], ['Tetap', 'Kontrak'])) {
    $where[] = "Status = ?";
    $params[] = $_GET['status'];
}

// Filter Unit
if (isset($_GET['unit']) && $_GET['unit'] !== '') {
    $where[] = "Unit_Kerja = ?";
    $params[] = $_GET['unit'];
}

// Filter Tahun Masuk
if (isset($_GET['year']) && $_GET['year'] !== '') {
    $where[] = "YEAR(Tgl_Masuk) = ?";
    $params[] = $_GET['year'];
}


// Buat SQL Query
$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
$sql = "SELECT * FROM pegawai $whereClause ORDER BY NIP";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();

// Ambil semua Unit untuk dropdown
$units = $pdo->query("SELECT DISTINCT Unit_Kerja FROM pegawai ORDER BY Unit_Kerja")->fetchAll();

// Handle sorting
$sortColumn = $_GET['sort'] ?? 'NIP';
$sortOrder = $_GET['order'] ?? 'ASC';

// Validate sort columns
$allowedColumns = ['NIP', 'Nama_Pegawai', 'Tgl_Lahir', 'Unit_Kerja', 'Jabatan', 'Status', 'Tgl_Masuk', 'Tgl_Keluar', 'Pendidikan', 'Pelatihan_Wajib', 'Email_Kerja'];
if (!in_array($sortColumn, $allowedColumns)) {
    $sortColumn = 'NIP';
}
$sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

// Modify SQL query to include sorting
$sql = "SELECT * FROM pegawai $whereClause ORDER BY $sortColumn $sortOrder";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll();
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Data Karyawan</h1></div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($_GET['added'])): ?>
                <div class="alert alert-success">Data karyawan berhasil ditambahkan.</div>
            <?php endif; ?>
            <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Data berhasil diperbarui.</div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="#" class="btn btn-secondary bg-success" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Karyawan
                    </a>
                    <form method="get" class="form-inline">
                        <select name="status" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Tetap" <?= isset($_GET['status']) && $_GET['status'] === 'Tetap' ? 'selected' : '' ?>>Tetap</option>
                            <option value="Kontrak" <?= isset($_GET['status']) && $_GET['status'] === 'Kontrak' ? 'selected' : '' ?>>Kontrak</option>
                        </select>

                        <select name="unit" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">Semua Unit</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?= htmlspecialchars($unit['Unit_Kerja']) ?>" <?= isset($_GET['unit']) && $_GET['unit'] === $unit['Unit_Kerja'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($unit['Unit_Kerja']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="year" class="form-control mr-2" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            <?php for ($year = date('Y'); $year >= 2010; $year--): ?>
                                <option value="<?= $year ?>" <?= isset($_GET['year']) && $_GET['year'] == $year ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                            <?php endfor; ?>
                        </select>

                        <?php if (!empty($_GET)): ?>
                            <a href="/xyz_studycase2/pages/employees.php" class="btn btn-secondary ml-2">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="card-body">
                    <table id="employeesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'Tgl_Lahir', 'order' => ($sortColumn === 'Tgl_Lahir' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'])) ?>">
                                        Tgl Lahir
                                        <?php if ($sortColumn === 'Tgl_Lahir'): ?>
                                            <i class="fas fa-sort-<?= strtolower($sortOrder) ?>"></i>
                                        <?php else: ?>
                                            <i class="fas fa-sort fa-xs"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>Unit Kerja</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'Tgl_Masuk', 'order' => ($sortColumn === 'Tgl_Masuk' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'])) ?>">
                                        Tgl Masuk
                                        <?php if ($sortColumn === 'Tgl_Masuk'): ?>
                                            <i class="fas fa-sort-<?= strtolower($sortOrder) ?>"></i>
                                        <?php else: ?>
                                            <i class="fas fa-sort fa-xs"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'Tgl_Keluar', 'order' => ($sortColumn === 'Tgl_Keluar' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'])) ?>">
                                        Tgl Keluar
                                        <?php if ($sortColumn === 'Tgl_Keluar'): ?>
                                            <i class="fas fa-sort-<?= strtolower($sortOrder) ?>"></i>
                                        <?php else: ?>
                                            <i class="fas fa-sort fa-xs"></i>
                                        <?php endif; ?>
                                    </a>
                                </th>
                                <th>Pendidikan</th>
                                <th>Pelatihan Wajib</th>
                                <th>Email Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($employees as $employee): ?>
                                <tr>
                                    <td><?= htmlspecialchars($employee['NIP']) ?></td>
                                    <td><?= htmlspecialchars($employee['Nama_Pegawai']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($employee['Tgl_Lahir'])) ?></td>
                                    <td><?= htmlspecialchars($employee['Unit_Kerja']) ?></td>
                                    <td><?= htmlspecialchars($employee['Jabatan']) ?></td>
                                    <td>
                                        <span class="badge <?= $employee['Status'] === 'Tetap' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= htmlspecialchars($employee['Status']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($employee['Tgl_Masuk'])) ?></td>
                                    <td>
                                        <?= $employee['Tgl_Keluar'] ? date('d/m/Y', strtotime($employee['Tgl_Keluar'])) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td><?= htmlspecialchars($employee['Pendidikan']) ?></td>
                                    <td><?= htmlspecialchars($employee['Pelatihan_Wajib']) ?></td>
                                    <td><?= htmlspecialchars($employee['Email_Kerja']) ?></td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <a href="/xyz_studycase2/pages/edit_employee.php?nip=<?= $employee['NIP'] ?>" 
                                        class="btn btn-sm btn-warning" 
                                        title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Tombol Delete -->
                                        <form method="POST" action="" style="display:inline;" 
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="nip" value="<?= $employee['NIP'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="add_employee.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP <span class="text-danger">*</span></label>
                                <input type="number" name="nip" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Pegawai <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_lahir" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Unit Kerja <span class="text-danger">*</span></label>
                                <input type="text" name="unit" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                        </div>
                        <!-- Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Tetap">Tetap</option>
                                    <option value="Kontrak">Kontrak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_masuk" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Keluar</label>
                                <input type="date" name="tgl_keluar" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pendidikan <span class="text-danger">*</span></label>
                                <input type="text" name="pendidikan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Pelatihan Wajib <span class="text-danger">*</span></label>
                                <input type="text" name="pelatihan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email Kerja <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <small class="text-danger">* Wajib diisi</small>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once '../includes/footer.php'; ?>

<style>
    /* Fix untuk footer agar tidak naik saat modal terbuka */
    body.modal-open {
        overflow: auto !important;
        padding-right: 0 !important;
    }
    .modal {
        overflow-y: auto;
    }
</style>