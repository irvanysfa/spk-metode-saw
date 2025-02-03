<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Pendukung Keputusan'; ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <?= $this->include('layout/header'); ?>

    <main>
        <?= $this->renderSection('content'); ?>
    </main>

    <?= $this->include('layout/footer'); ?>
</body>
</html>
