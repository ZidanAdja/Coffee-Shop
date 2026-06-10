<?php

class DashboardRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Get 4 KPI
    public function getKpi(): array
    {
        // Total Pendapatan & Total Produk Terjual (From Tabel detail_transaksi)
        $stmt1 = $this->pdo->query("SELECT SUM(jumlah * harga) as total_pendapatan, SUM(jumlah) as total_produk FROM detail_transaksi");
        $row1  = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Total Transaksi (From Tabel transaksi)
        $stmt2 = $this->pdo->query("SELECT COUNT(id_transaksi) as total_transaksi FROM transaksi");
        $row2  = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Total Pelanggan (From Tabel pelanggan)
        $stmt3 = $this->pdo->query("SELECT COUNT(id_pelanggan) as total_pelanggan FROM pelanggan");
        $row3  = $stmt3->fetch(PDO::FETCH_ASSOC);

        return [
            'transaksi'  => (int)($row2['total_transaksi'] ?? 0),
            'pendapatan' => (float)($row1['total_pendapatan'] ?? 0),
            'pelanggan'  => (int)($row3['total_pelanggan'] ?? 0),
            'produk'     => (int)($row1['total_produk'] ?? 0)
        ];
    }

    // Query Tren Penjualan Per Bulan
    public function getPenjualanPerBulan(): array
    {
        $stmt = $this->pdo->query("
            SELECT DATE_FORMAT(t.tanggal, '%Y-%m') as bulan, SUM(dt.jumlah * dt.harga) as revenue
            FROM transaksi t
            JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            GROUP BY bulan
            ORDER BY bulan ASC
        ");

        $labels = []; 
        $data   = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $labels[] = $row['bulan'];
            $data[]   = (float)$row['revenue'];
        }
        
        return [
            'labels' => $labels, 
            'data'   => $data
        ];
    }

    // Query Penjualan Berdasarkan Kategori
    public function getPenjualanKategori(): array
    {
        $stmt = $this->pdo->query("
            SELECT k.kategori_produk, SUM(dt.jumlah * dt.harga) as revenue
            FROM detail_transaksi dt
            JOIN produk p ON dt.id_produk = p.id_produk
            JOIN kategori k ON p.id_kategori = k.id_kategori
            GROUP BY k.id_kategori, k.kategori_produk
            ORDER BY revenue DESC
        ");

        $labels = []; 
        $data   = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $labels[] = $row['kategori_produk'];
            $data[]   = (float)$row['revenue'];
        }
        
        return [
            'labels' => $labels, 
            'data'   => $data
        ];
    }

    // Query Top 5 Produk Terlaris (Unit Terjual)
    public function getTop5Produk(): array
    {
        $stmt = $this->pdo->query("
            SELECT p.nama_produk, SUM(dt.jumlah) as total_terjual
            FROM detail_transaksi dt
            JOIN produk p ON dt.id_produk = p.id_produk
            GROUP BY p.id_produk, p.nama_produk
            ORDER BY total_terjual DESC
            LIMIT 5
        ");

        $labels = []; 
        $data   = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $labels[] = $row['nama_produk'];
            $data[]   = (int)$row['total_terjual'];
        }
        
        return [
            'labels' => $labels, 
            'data'   => $data
        ];
    }

    // Query Top 5 Kota Berdasarkan Transaksi
    public function getTop5Kota(): array
    {
        $stmt = $this->pdo->query("
            SELECT k.kota, COUNT(t.id_transaksi) as total_transaksi
            FROM transaksi t
            JOIN kota k ON t.id_kota = k.id_kota
            GROUP BY k.id_kota, k.kota
            ORDER BY total_transaksi DESC
            LIMIT 5
        ");

        $labels = []; 
        $data   = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $labels[] = $row['kota'];
            $data[]   = (int)$row['total_transaksi'];
        }
        
        return [
            'labels' => $labels, 
            'data'   => $data
        ];
    }

    // Query Total Penjualan Setiap Sales & Rangking Sales
    public function getAnalisisSales(): array
    {
        $stmt = $this->pdo->query("
            SELECT s.sales as nama_sales, SUM(dt.jumlah * dt.harga) as total_pendapatan
            FROM transaksi t
            JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
            JOIN sales s ON t.id_sales = s.id_sales
            GROUP BY s.id_sales, s.sales
            ORDER BY total_pendapatan DESC
        ");
        
        $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $labels    = []; 
        $data      = [];
        
        foreach ($salesData as $row) {
            $labels[] = $row['nama_sales'];
            $data[]   = (float)$row['total_pendapatan'];
        }
        
        // Return 2 Jenis Data: Chart & Tabel Leaderboard
        return [
            'chart' => [
                'labels' => $labels, 
                'data'   => $data
            ],
            'table' => $salesData
        ];
    }
}
?>