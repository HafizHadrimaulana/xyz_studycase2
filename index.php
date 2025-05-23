<?php
$pageTitle = 'Dashboard';
require_once 'includes/auth_check.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'config/database.php';
?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Small Boxes (Stat boxes) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php
                            $stmt = $pdo->query("SELECT COUNT(*) FROM pegawai");
                            $totalEmployees = $stmt->fetchColumn();
                            ?>
                            <h3><?= $totalEmployees ?></h3>
                            <p>Total Karyawan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="/xyz_studycase2/pages/employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <?php
                            $stmt = $pdo->query("SELECT COUNT(*) FROM pegawai WHERE Status = 'Tetap'");
                            $permanentEmployees = $stmt->fetchColumn();
                            ?>
                            <h3><?= $permanentEmployees ?></h3>
                            <p>Karyawan Tetap</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="/xyz_studycase2/pages/employees.php?status=Tetap" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <?php
                            $stmt = $pdo->query("SELECT COUNT(*) FROM pegawai WHERE Status = 'Kontrak'");
                            $contractEmployees = $stmt->fetchColumn();
                            ?>
                            <h3><?= $contractEmployees ?></h3>
                            <p>Karyawan Kontrak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <a href="/xyz_studycase2/pages/employees.php?status=Kontrak" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <?php
                            $currentYear = date('Y');
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM pegawai WHERE YEAR(Tgl_Masuk) = ?");
                            $stmt->execute([$currentYear]);
                            $newHires = $stmt->fetchColumn();
                            ?>
                            <h3><?= $newHires ?></h3>
                            <p>Rekrutmen Tahun Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="/xyz_studycase2/pages/employees.php?year=<?= $currentYear ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Analysis Charts Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-gradient-purple">
                            <h3 class="card-title">Usia Rata-Rata per Unit Kerja</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            $ageData = $pdo->query("
                                SELECT Unit_Kerja, AVG(YEAR(CURRENT_DATE) - YEAR(Tgl_Lahir)) as avg_age 
                                FROM pegawai 
                                GROUP BY Unit_Kerja
                                ORDER BY avg_age DESC
                            ")->fetchAll();
                            ?>
                            <canvas id="ageChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-gradient-purple">
                            <h3 class="card-title">Status Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            $statusData = $pdo->query("
                                SELECT Status, COUNT(*) as count 
                                FROM pegawai 
                                GROUP BY Status
                            ")->fetchAll();
                            ?>
                            <canvas id="statusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-gradient-purple">
                            <h3 class="card-title">Tingkat Pendidikan</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            $educationData = $pdo->query("
                                SELECT Pendidikan, COUNT(*) as count 
                                FROM pegawai 
                                GROUP BY Pendidikan
                            ")->fetchAll();
                            ?>
                            <canvas id="educationChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-gradient-purple">
                            <h3 class="card-title">Status Kompetensi Pegawai</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            $kompetensiData = $pdo->query("
                                SELECT 
                                    COUNT(*) as count,
                                    CASE 
                                        WHEN (
                                            (CASE 
                                                WHEN Pendidikan IN ('S2', 'Magister') THEN 2
                                                WHEN Pendidikan IN ('S1', 'Sarjana', 'S.Kom') THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Pelatihan_Wajib IN ('ya', 'Sudah') THEN 2
                                                WHEN Pelatihan_Wajib = 'Tidak tahu' THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Jabatan IN ('VP', 'Manajer', 'Kepala Divisi') THEN 2
                                                WHEN Jabatan IN ('Supervisor', 'Officer', 'Senior Officer', 'Senior Staff', 'Staff') THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Status = 'Tetap' THEN 1
                                                ELSE 0 END)
                                        ) >= 6 THEN 'Tinggi'
                                        WHEN (
                                            (CASE 
                                                WHEN Pendidikan IN ('S2', 'Magister') THEN 2
                                                WHEN Pendidikan IN ('S1', 'Sarjana', 'S.Kom') THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Pelatihan_Wajib IN ('ya', 'Sudah') THEN 2
                                                WHEN Pelatihan_Wajib = 'Tidak tahu' THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Jabatan IN ('VP', 'Manajer', 'Kepala Divisi') THEN 2
                                                WHEN Jabatan IN ('Supervisor', 'Officer', 'Senior Officer', 'Senior Staff', 'Staff') THEN 1
                                                ELSE 0 END) +
                                            (CASE 
                                                WHEN Status = 'Tetap' THEN 1
                                                ELSE 0 END)
                                        ) BETWEEN 4 AND 5 THEN 'Menengah'
                                        ELSE 'Rendah'
                                    END AS Kategori
                                FROM pegawai
                                GROUP BY Kategori
                            ")->fetchAll();
                            ?>
                            <canvas id="kompetensiChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-gradient-purple text-white">
                <h3 class="card-title">Turnover Rate</h3>
            </div>
            <div class="card-body">
                <?php
                $currentYear = date('Y');
                $today = date('Y-m-d');

                // Hitung pegawai keluar dari awal tahun hingga hari ini
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM pegawai WHERE Tgl_Keluar BETWEEN ? AND ?");
                $stmt->execute(["$currentYear-01-01", $today]);
                $jumlahKeluar = $stmt->fetchColumn();

                // Pegawai aktif di awal tahun
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM pegawai WHERE Tgl_Masuk <= ? AND (Tgl_Keluar IS NULL OR Tgl_Keluar >= ?)");
                $stmt->execute(["$currentYear-01-01", "$currentYear-01-01"]);
                $awalTahun = $stmt->fetchColumn();

                // Pegawai aktif saat ini
                $stmt->execute([$today, $today]);
                $saatIni = $stmt->fetchColumn();

                // Rata-rata pegawai aktif sampai hari ini
                $rataRataPegawai = ($awalTahun + $saatIni) / 2;

                // Hitung turnover rate
                $turnoverRate = $rataRataPegawai > 0 ? ($jumlahKeluar / $rataRataPegawai) * 100 : 0;

                // Data trend pegawai aktif per bulan
                $bulanLabels = [];
                $dataPegawaiAktif = [];

                for ($i = 1; $i <= date('n'); $i++) {
                    $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $tanggal = "$currentYear-$bulan-01";

                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pegawai WHERE Tgl_Masuk <= ? AND (Tgl_Keluar IS NULL OR Tgl_Keluar >= ?)");
                    $stmt->execute([$tanggal, $tanggal]);
                    $jumlahAktif = $stmt->fetchColumn();

                    $bulanLabels[] = date('M', strtotime($tanggal));
                    $dataPegawaiAktif[] = (int) $jumlahAktif;
                }
                ?>
                <div class="text-center mb-3">
                    <h1 class="<?= $turnoverRate > 10 ? 'text-danger' : 'text-success' ?>">
                        <?= number_format($turnoverRate, 2) ?>%
                    </h1>
                    <p>Turnover pegawai tahun <?= $currentYear ?> (sampai <?= date('d M Y') ?>)</p>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-<?= $turnoverRate > 10 ? 'danger' : 'success' ?>" 
                        role="progressbar" 
                        style="width: <?= min($turnoverRate, 100) ?>%" 
                        aria-valuenow="<?= min($turnoverRate, 100) ?>" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                    </div>
                </div>
                <p class="mt-3 text-muted text-center">
                    <?= $jumlahKeluar ?> pegawai keluar | Rata-rata pegawai aktif: <?= round($rataRataPegawai) ?>
                </p>
                <hr>
                <h5 class="text-center">Trend Pegawai Aktif per Bulan</h5>
                <canvas id="pegawaiTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('pegawaiTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulanLabels) ?>,
        datasets: [{
            label: 'Pegawai Aktif',
            data: <?= json_encode($dataPegawaiAktif) ?>,
            backgroundColor: 'rgba(99, 102, 241, 0.2)',
            borderColor: 'rgba(99, 102, 241, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
<script src="/xyz_studycase2/assets/vendor/adminlte/plugins/chart.js/Chart.min.js"></script>
<script>
// Usia Rata-Rata Chart
var ageCtx = document.getElementById('ageChart').getContext('2d');
var ageChart = new Chart(ageCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($ageData, 'Unit_Kerja')) ?>,
        datasets: [{
            label: 'Usia Rata-Rata',
            data: <?= json_encode(array_column($ageData, 'avg_age')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Usia (Tahun)'
                }
            }
        }
    }
});

// Status Karyawan Chart
var statusCtx = document.getElementById('statusChart').getContext('2d');
var statusChart = new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($statusData, 'Status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($statusData, 'count')) ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});

// Chart Status Kompetensi Pegawai
var kompetensiCtx = document.getElementById('kompetensiChart').getContext('2d');
var kompetensiChart = new Chart(kompetensiCtx, {
    type: 'pie',
    data: {
        labels: <?= json_encode(array_column($kompetensiData, 'Kategori')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($kompetensiData, 'count')) ?>,
            backgroundColor: [
                'rgba(255, 230, 0, 0.6)',
                'rgba(255, 0, 0, 0.6)',
                'rgba(86, 244, 54, 0.6)'
            ],
            borderColor: [
                'rgba(255, 230, 0, 0.6)',
                'rgba(255, 0, 0, 0.6)',
                'rgba(86, 244, 54, 0.6)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});

// Pendidikan Chart
var educationCtx = document.getElementById('educationChart').getContext('2d');
var educationChart = new Chart(educationCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($educationData, 'Pendidikan')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($educationData, 'count')) ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>