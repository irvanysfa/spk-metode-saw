<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <img src="<?= base_url('asset/img/smp1ambal.jpg') ?>" alt="Deskripsi Gambar" class="logo">
        <h2>Register Admin</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>

        <form action="<?= site_url('register/process') ?>" method="post">
            <div class="form-group">
                <label for="nama_admin">Nama Lengkap:</label>
                <input type="text" name="nama_admin" required><br>
            </div>
            <div class="form-group">
                <label for="user_name">Username:</label>
                <input type="text" name="user_name" required><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>