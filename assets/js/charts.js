const d = dashboardData;

// Format Rp
const formatRp = (value) => 'Rp ' + value.toLocaleString('id-ID');

// Format Angka
const formatNumber = (value) => value.toLocaleString('id-ID');

Chart.defaults.color = '#8C7A6B';
Chart.defaults.font.family = "'Poppins', sans-serif";

const pastelCoffeeColors = [
    '#B79477', '#A3B18A', '#E0A96D', '#D5BDAF', 
    '#C6AC8F', '#CCD5AE', '#9C6644', '#E6CCB2',
    '#A88264', '#EDC9AF', '#DAD7CD', '#B5C9B5'
];

// Tren Penjualan Per Bulan
new Chart(document.getElementById('penjualanBulanChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: d.penjualan_bulan.labels,
        datasets: [{
            label: 'Total Pendapatan (Rp)',
            data: d.penjualan_bulan.data,
            borderColor: '#B79477',
            backgroundColor: 'rgba(183, 148, 119, 0.15)',
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 4,
            pointBackgroundColor: '#B79477',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false } 
        },
        scales: {
            y: {
                grid: { color: '#EFE9E1' },
                ticks: { callback: formatRp }
            },
            x: { 
                grid: { display: false } 
            }
        }
    }
});

// Penjualan Berdasarkan Kategori
new Chart(document.getElementById('kategoriChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: d.kategori.labels,
        datasets: [{
            data: d.kategori.data,
            backgroundColor: pastelCoffeeColors,
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'right', 
                labels: { color: '#3D312A' } 
            },
            tooltip: {
                callbacks: {
                    label: (ctx) => {
                        return ' ' + ctx.label + ': ' + formatRp(ctx.raw);
                    }
                }
            }
        }
    }
});

// Top 5 Produk Terlaris (Unit Terjual)
new Chart(document.getElementById('topProdukChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: d.top_produk.labels,
        datasets: [{
            label: 'Total Terjual (Unit)',
            data: d.top_produk.data,
            backgroundColor: 'rgba(163, 177, 138, 0.85)',
            borderColor: '#A3B18A',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false } 
        },
        scales: {
            x: { 
                grid: { color: '#EFE9E1' }, 
                ticks: { callback: formatNumber } 
            },
            y: { 
                grid: { display: false } 
            }
        }
    }
});

// Top 5 Kota Berdasarkan Transaksi
new Chart(document.getElementById('topKotaChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: d.top_kota.labels,
        datasets: [{
            label: 'Total Transaksi',
            data: d.top_kota.data,
            backgroundColor: 'rgba(224, 169, 109, 0.85)',
            borderColor: '#E0A96D',
            borderWidth: 1,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false } 
        },
        scales: {
            y: { 
                grid: { color: '#EFE9E1' }, 
                ticks: { callback: formatNumber } 
            },
            x: { 
                grid: { display: false } 
            }
        }
    }
});

// Total Penjualan Setiap Sales
new Chart(document.getElementById('salesChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: d.sales.chart.labels,
        datasets: [{
            label: 'Pendapatan Sales (Rp)',
            data: d.sales.chart.data,
            backgroundColor: pastelCoffeeColors.slice(4, 10),
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false } 
        },
        scales: {
            y: { 
                grid: { color: '#EFE9E1' }, 
                ticks: { callback: formatRp } 
            },
            x: { 
                grid: { display: false } 
            }
        }
    }
});