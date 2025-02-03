<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-utama">
    <h2>Data Siswa</h2>

    <a href="<?= base_url('/siswa/create') ?>" class="btn btn-primary">Tambah Siswa</a>
    <form method="get" action="<?= base_url('/siswa') ?>">
        <label for="kelas">Pilih Kelas:</label>
        <select name="kelas" id="kelas" class="form-control" onchange="this.form.submit()">
            <option value="">Semua Kelas</option>
            <option value="1" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '1') ? 'selected' : '' ?>>Kelas 1</option>
            <option value="2" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '2') ? 'selected' : '' ?>>Kelas 2</option>
            <option value="3" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '3') ? 'selected' : '' ?>>Kelas 3</option>
            <option value="4" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '4') ? 'selected' : '' ?>>Kelas 4</option>
            <option value="5" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '5') ? 'selected' : '' ?>>Kelas 5</option>
            <option value="6" <?= (isset($_GET['kelas']) && $_GET['kelas'] == '6') ? 'selected' : '' ?>>Kelas 6</option>
        </select>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Absen</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s['nomor_absen'] ?></td>
                    <td><?= $s['nama_siswa'] ?></td>
                    <td><?= $s['kelas'] ?></td>
                    <td>
                        <?php foreach ($kriteria as $k): ?>
                            <?php
                            $nilai_kriteria = '-';
                            foreach ($s['nilai'] as $n) {
                                if ($n['id_kriteria'] == $k['id_kriteria']) {
                                    $nilai_kriteria = $n['nilai'];
                                    break;
                                }
                            }
                            ?>
                            <span class='badge bg-info'><?= $k['nama_kriteria'] ?>: <?= $nilai_kriteria ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('/siswa/edit/' . $s['id_siswa']) ?>" class="btn btn-warning btn-sm">Edit Siswa</a>
                        <a href="<?= base_url('/siswa/edit-nilai/' . $s['id_siswa']) ?>" class="btn btn-success btn-sm">Edit Nilai</a>
                        <a href="<?= base_url('/siswa/delete/' . $s['id_siswa']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>