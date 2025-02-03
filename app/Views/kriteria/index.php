<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-utama">
    <h2>Data Kriteria</h2>

    <a href="<?= base_url('/kriteria/create') ?>" class="btn btn-primary">Tambah Kriteria</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kriteria</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Sifat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($kriteria as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($k['kode_kriteria']) ?></td>
                    <td><?= esc($k['nama_kriteria']) ?></td>
                    <td><?= esc($k['bobot']) ?></td>
                    <td><?= esc($k['sifat']) ?></td>
                    <td>
                        <a href="<?= base_url('/kriteria/edit/' . $k['id_kriteria']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= base_url('/kriteria/delete/' . $k['id_kriteria']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>