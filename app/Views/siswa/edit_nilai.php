<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Nilai Siswa: <?= $siswa['nama_siswa'] ?></h2>

<form action="<?= base_url('/siswa/update-nilai') ?>" method="post">
    <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">

    <?php foreach ($kriteria as $k): ?>
        <?php
        $existingNilai = array_filter($nilai, function ($n) use ($k) {
            return $n['id_kriteria'] == $k['id_kriteria'];
        });
        $existingNilai = reset($existingNilai);
        ?>
        <div class="mb-3">
            <label for="nilai_<?= $k['id_kriteria'] ?>" class="form-label"><?= $k['nama_kriteria'] ?></label>
            <input type="hidden" name="id_kriteria[]" value="<?= $k['id_kriteria'] ?>">
            <input type="number" class="form-control" name="nilai[]" id="nilai_<?= $k['id_kriteria'] ?>" value="<?= $existingNilai ? $existingNilai['nilai'] : '' ?>" step="0.01" required>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('/siswa') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
