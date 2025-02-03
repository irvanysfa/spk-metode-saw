<?php $this->extend('layout/main'); ?>

<?php $this->section('content'); ?>
    <div class="container-utama">
        <h2>Dashboard Admin</h2>
        <p>Selamat datang, <?= session()->get('nama_admin') ?? 'Admin'; ?>! Berikut adalah informasi dashboard Anda:</p>
        
        <div class="card">
            <h3>Statistik Pengguna</h3>
            <p>Total Admin: 5</p>
            <p>Total Siswa: 120</p>
        </div>
        
        <div class="card">
            <h3>Aktivitas Terakhir</h3>
            <p>Login terakhir pada: <?= session()->get('last_login') ?? 'Belum ada aktivitas'; ?></p>
        </div>
        
        <!-- Tambahkan elemen lainnya sesuai kebutuhan -->
    </div>
<?php $this->endSection(); ?>
