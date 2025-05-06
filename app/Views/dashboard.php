<?php $this->extend('layout/main'); ?>

<?php $this->section('content'); ?>
<!-- Hero Section -->
<div class="hero-section" style="background-image: url('<?= base_url('asset/img/hero2.jpeg') ?>');">
    <div class="overlay"></div>
    <div class="hero-caption">
        <p>Selamat datang <?= session()->get('nama_admin') ?? 'Admin'; ?> di dashboard</p>
        <h1>SISTEM PENDUKUNG KEPUTUSAN LULUSAN BERPRESTASI</h1>
        <h2>SMP N 1 AMBAL</h2>
    </div>
</div>
<div class="container-utama">
    <h2>Dashboard Admin</h2>
    <div class="card">
        <h3>Grafik Rata-rata Nilai Total Top 10 Siswa per Tahun</h3>
        <canvas id="chartTop10" height="100"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartTop10').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($grafik, 'tahun_angkatan')) ?>,
                datasets: [{
                    label: 'Rata-rata Total Nilai',
                    data: <?= json_encode(array_map('floatval', array_column($grafik, 'rata_rata'))) ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Rata-rata Nilai Top 10 per Tahun Angkatan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nilai Rata-rata'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tahun Angkatan'
                        }
                    }
                }
            }
        });
    </script>
    <div class="card">
        <h3>Aktivitas Terakhir</h3>
        <p>Login terakhir pada: <?= session()->get('last_login') ?? 'Belum ada aktivitas'; ?></p>
    </div>
    <!-- Tambahkan elemen lainnya sesuai kebutuhan -->
</div>
<?php $this->endSection(); ?>