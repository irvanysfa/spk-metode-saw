<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-utama">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <h2>Data Nilai</h2>
    <a href="<?= base_url('/nilai/create') ?>" class="btn btn-primary">Tambah Nilai</a>

    <!-- Form untuk memilih kriteria -->
    <form method="get" action="<?= base_url('/nilai') ?>" class="mt-3">
        <label for="kriteria" class="label-lb">Pilih Kriteria:</label>
        <select name="kriteria" id="kriteria" class="form-control" onchange="this.form.submit()">
            <option value="">Semua Kriteria</option>
            <?php foreach ($kriteria as $k): ?>
                <option value="<?= $k['id_kriteria'] ?>" <?= ($selected_kriteria == $k['id_kriteria']) ? 'selected' : '' ?>>
                    <?= $k['nama_kriteria'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kriteria</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($nilai as $n): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $n['nama_siswa'] ?></td>
                    <td><?= $n['nama_kriteria'] ?></td>
                    <td><?= $n['nilai'] ?></td>
                    <td>
                        <a href="<?= base_url('/nilai/edit/' . $n['id_nilai']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= base_url('/nilai/delete/' . $n['id_nilai']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
