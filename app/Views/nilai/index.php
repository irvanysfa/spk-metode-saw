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

    <form method="get" action="<?= base_url('/nilai') ?>" class="mt-3 d-flex gap-2 align-items-end flex-wrap">
        <div>
            <label for="kriteria" class="label-lb">Kriteria:</label>
            <select name="kriteria" id="kriteria" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Kriteria</option>
                <?php foreach ($kriteria as $k): ?>
                    <option value="<?= $k['id_kriteria'] ?>" <?= ($selected_kriteria == $k['id_kriteria']) ? 'selected' : '' ?>>
                        <?= $k['nama_kriteria'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="kelas" class="label-lb">Kelas:</label>
            <select name="kelas" id="kelas" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                <?php foreach ($kelasList as $k): ?>
                    <option value="<?= $k['kelas'] ?>" <?= ($selected_kelas == $k['kelas']) ? 'selected' : '' ?>><?= $k['kelas'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="angkatan" class="label-lb">Tahun Angkatan:</label>
            <select name="angkatan" id="angkatan" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatanList as $a): ?>
                    <option value="<?= $a['tahun_angkatan'] ?>" <?= ($selected_angkatan == $a['tahun_angkatan']) ? 'selected' : '' ?>><?= $a['tahun_angkatan'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="d-block">&nbsp;</label>
            <a href="<?= base_url('/nilai') ?>" class="btn btn-secondary">Reset Filter</a>
        </div>
    </form>

    <!-- Live Search Siswa -->
    <div class="mb-3">
        <label for="search-nama" class="form-label">Cari Siswa:</label>
        <input type="text" id="search-nama" class="form-control" placeholder="Ketik nama siswa...">
    </div>



    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Angkatan</th>
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
                    <td><?= $n['kelas'] ?></td>
                    <td><?= $n['tahun_angkatan'] ?></td>
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
<script src="<?= base_url('js/nilai.js') ?>"></script>
<?= $this->endSection() ?>