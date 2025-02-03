<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Nilai</h2>
<form action="<?= base_url('/nilai/store') ?>" method="post">
    <div class="mb-3">
        <label for="id_siswa" class="form-label">Siswa</label>
        <select class="form-control" id="id_siswa" name="id_siswa" required>
            <?php foreach ($siswa as $s): ?>
                <option value="<?= $s['id_siswa'] ?>"><?= $s['nama_siswa'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="id_kriteria" class="form-label">Kriteria</label>
        <select class="form-control" id="id_kriteria" name="id_kriteria" required>
            <?php foreach ($kriteria as $k): ?>
                <option value="<?= $k['id_kriteria'] ?>"><?= $k['nama_kriteria'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="nilai" class="form-label">Nilai</label>
        <input type="number" step="0.01" class="form-control" id="nilai" name="nilai" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>


<?= $this->endSection() ?>