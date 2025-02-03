<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SPK Siswa' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    $uri = service('uri')->getSegment(1); // Ambil segment pertama dari URL
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <img src="<?= base_url('asset/img/logo-tutwuri.jpg') ?>" alt="Logo Header" class="logo-header">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'dashboard' || $uri == '') ? 'active' : '' ?>" href="/dashboard">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'siswa') ? 'active' : '' ?>" href="/siswa">Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'kriteria') ? 'active' : '' ?>" href="/kriteria">Kriteria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'nilai') ? 'active' : '' ?>" href="/nilai">Nilai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'perhitungan') ? 'active' : '' ?>" href="/perhitungan">Perhitungan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($uri == 'hasil') ? 'active' : '' ?>" href="/hasil">Hasil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="<?= base_url('/logout') ?>" onclick="return confirm('Yakin ingin logout?')">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>