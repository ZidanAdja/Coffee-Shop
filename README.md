# Coffee Shop Analytical Dashboard

<div align="justify">
    <b>Coffee Shop Analytical Dashboard</b> adalah platform berbasis web yang dirancang untuk menyajikan visualisasi data analitik dan performa penjualan kedai kopi secara <b>real-time</b>. Dashboard ini membantu pemilik bisnis dalam memantau Key Performance Indicators (KPI), tren pendapatan bulanan, efektivitas tim sales, hingga demografi transaksi berdasarkan wilayah kota.
</div>

---

## 🚀 Fitur Utama

1. **Ringkasan Key Performance Indicators (KPI)**
   * **Total Transaksi**: Menghitung jumlah akumulasi transaksi yang berhasil diproses.
   * **Total Pendapatan**: Akumulasi nilai finansial dari seluruh detail transaksi dalam Rupiah (Rp).
   * **Total Pelanggan**: Jumlah pelanggan unik yang terdaftar di basis data.
   * **Total Produk Terjual**: Total kuantitas (unit) produk kopi dan varian lainnya yang telah terjual.
2. **Visualisasi Tren Penjualan Per Bulan**
   * Grafik garis (*Line Chart*) interaktif untuk memantau fluktuasi grafik pendapatan bulanan.
3. **Analisis Kategori & Produk Terlaris**
   * Grafik donat (*Doughnut Chart*) untuk segmentasi kontribusi pendapatan per kategori produk.
   * Grafik batang horizontal (*Horizontal Bar Chart*) menampilkan 5 produk paling laris (berdasarkan unit terjual).
4. **Demografi & Distribusi Wilayah**
   * Grafik batang (*Bar Chart*) untuk memetakan Top 5 Kota dengan frekuensi transaksi tertinggi.
5. **Leaderboard & Analisis Kinerja Sales**
   * Grafik batang komparatif penjualan antar staf marketing.
   * Komponen *Leaderboard/Ranking Sales Terbaik* interaktif yang dilengkapi dengan indikator mahkota (Crown Badge) untuk peringkat pertama serta *progress bar* proporsional.

---

## 🛠️ Teknologi yang Digunakan

* **Backend / Server-Side:**
  * PHP 8.x (Native dengan implementasi OOP & Data Access Object Pattern via PDO)
  * MySQL / MariaDB
* **Frontend / UI:**
  * HTML5 & CSS3 Custom (Tema estetis bernuansa *Pastel Coffee*)
  * Bootstrap 5.3.0 (Framework CSS untuk tata letak responsif)
  * Font Awesome 6.4.0 (Penyedia aset ikon kustom)
* **Visualisasi Data:**
  * Chart.js (Library JavaScript untuk pembuatan chart interaktif)

---

## 📁 Struktur Proyek

```text
📦 coffee-shop
 ┣ 📂 assets
 ┃ ┣ 📂 css
 ┃ ┃ ┗ 📜 style.css          # Kustomisasi tema warna pastel coffee, KPI, & leaderboard
 ┃ ┗ 📂 js
 ┃   ┗ 📜 charts.js         # Inisialisasi & konfigurasi Chart.js (format Rp & angka)
 ┣ 📂 config
 ┃ ┗ 📜 database.php        # Implementasi database singleton connection menggunakan PDO
 ┣ 📂 src
 ┃ ┗ 📜 DashboardRepository.php # Layer data repository berisi raw query SQL analitik
 ┣ 📜 index.php             # Halaman utama aplikasi (Controller & View integrasi)
 ┗ 📜 README.md             # Dokumentasi proyek
