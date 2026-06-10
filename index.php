<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/DashboardRepository.php';

$pdo        = Database::getConnection();
$repository = new DashboardRepository($pdo);

// Get Data KPI
$kpi             = $repository->getKpi();
$totalTransaksi  = number_format($kpi['transaksi'], 0, ',', '.');
$totalPendapatan = number_format($kpi['pendapatan'], 0, ',', '.');
$totalPelanggan  = number_format($kpi['pelanggan'], 0, ',', '.');
$totalProduk     = number_format($kpi['produk'], 0, ',', '.');

// Get Data Visualisasi Chart & Tabel
$chartData = [
    'penjualan_bulan' => $repository->getPenjualanPerBulan(),
    'kategori'        => $repository->getPenjualanKategori(),
    'top_produk'      => $repository->getTop5Produk(),
    'top_kota'        => $repository->getTop5Kota(),
    'sales'           => $repository->getAnalisisSales()
];

// Data Leadeboard Sales
$rankingSales = $chartData['sales']['table'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coffee Shop Analytical Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 px-md-4">
                
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
                    <h1 class="h2"><i class="fas fa-coffee me-2"></i> Coffee Shop Analytics</h1>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card kpi-card bg-gradient-transaksi text-white">
                            <h6 class="card-title">Total Transaksi</h6>
                            <h3 class="fw-bold"><?= $totalTransaksi ?></h3>
                            <i class="fas fa-shopping-cart kpi-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card kpi-card bg-gradient-pendapatan text-white">
                            <h6 class="card-title">Total Pendapatan</h6>
                            <h3 class="fw-bold">Rp <?= $totalPendapatan ?></h3>
                            <i class="fas fa-wallet kpi-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card kpi-card bg-gradient-pelanggan text-white">
                            <h6 class="card-title">Total Pelanggan</h6>
                            <h3 class="fw-bold"><?= $totalPelanggan ?></h3>
                            <i class="fas fa-users kpi-icon"></i>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <div class="card kpi-card bg-gradient-produk text-white">
                            <h6 class="card-title">Total Produk Terjual</h6>
                            <h3 class="fw-bold"><?= $totalProduk ?></h3>
                            <i class="fas fa-box-open kpi-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8 mb-4 mb-md-0">
                        <div class="card p-4">
                            <h5 class="mb-4">Tren Penjualan Per Bulan</h5>
                            <div class="chart-container">
                                <canvas id="penjualanBulanChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5 class="mb-4">Penjualan Berdasarkan Kategori</h5>
                            <div class="chart-container">
                                <canvas id="kategoriChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="card p-4">
                            <h5 class="mb-4">Top 5 Produk Terlaris (Unit Terjual)</h5>
                            <div class="chart-container">
                                <canvas id="topProdukChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-4">
                            <h5 class="mb-4">Top 5 Kota Berdasarkan Transaksi</h5>
                            <div class="chart-container">
                                <canvas id="topKotaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8 mb-4 mb-md-0">
                        <div class="card p-4">
                            <h5 class="mb-4">Total Penjualan Setiap Sales</h5>
                            <div class="chart-container">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card p-4">
                            <h5 class="mb-4"><i class="fas fa-trophy text-warning me-2"></i> Ranking Sales Terbaik</h5>
                            <div class="sales-leaderboard-container">
                                <?php 
                                $no            = 1;
                                $maxPendapatan = 1;
                                
                                if (!empty($rankingSales)) {
                                    $maxPendapatan = max(array_column($rankingSales, 'total_pendapatan'));
                                }
                                
                                foreach ($rankingSales as $sales) : 
                                    if ($no == 1) {
                                        $rankClass     = 'rank-1';
                                        $avatarClass   = 'sales-avatar-1';
                                        $progressClass = 'sales-progress-bar-1';
                                    } elseif ($no == 2) {
                                        $rankClass     = 'rank-2';
                                        $avatarClass   = 'sales-avatar-2';
                                        $progressClass = 'sales-progress-bar-2';
                                    } elseif ($no == 3) {
                                        $rankClass     = 'rank-3';
                                        $avatarClass   = 'sales-avatar-3';
                                        $progressClass = 'sales-progress-bar-3';
                                    } else {
                                        $rankClass     = 'rank-default';
                                        $avatarClass   = '';
                                        $progressClass = '';
                                    }
                                    
                                    $words    = explode(" ", $sales['nama_sales']);
                                    $initials = "";
                                    
                                    foreach ($words as $w) {
                                        $initials .= strtoupper($w[0] ?? '');
                                    }
                                    
                                    $initials   = substr($initials, 0, 2);
                                    $percentage = ($sales['total_pendapatan'] / $maxPendapatan) * 100;
                                ?>
                                <div class="sales-rank-item">
                                    <div class="rank-badge-container">
                                        <div class="rank-number-badge <?= $rankClass ?>">
                                            <?php if($no == 1): ?>
                                                <i class="fas fa-crown" style="font-size: 0.75rem;"></i>
                                            <?php else: ?>
                                                <?= $no ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="sales-avatar <?= $avatarClass ?>">
                                        <?= htmlspecialchars($initials) ?>
                                    </div>
                                    <div class="sales-info-block">
                                        <div class="sales-name-text"><?= htmlspecialchars($sales['nama_sales']) ?></div>
                                        <div class="sales-progress-wrapper">
                                            <div class="sales-progress-bar <?= $progressClass ?>" style="width: <?= $percentage ?>%;"></div>
                                        </div>
                                    </div>
                                    <div class="sales-revenue-display">
                                        Rp <?= number_format($sales['total_pendapatan'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <?php 
                                    $no++;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dashboardData = <?= json_encode($chartData, JSON_NUMERIC_CHECK) ?>;
    </script>
    <script src="assets/js/charts.js"></script>
</body>
</html>