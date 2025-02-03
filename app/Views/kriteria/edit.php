<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <h2>Edit Kriteria</h2>
    <form action="/kriteria/update/<?= $kriteria['id_kriteria'] ?>" method="post">
        <div class="mb-3">
            <label for="kode_kriteria" class="form-label">Kode Kriteria</label>
            <input type="text" class="form-control" id="kode_kriteria" name="kode_kriteria" value="<?= $kriteria['kode_kriteria'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" value="<?= $kriteria['nama_kriteria'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="bobot" class="form-label">Bobot</label>
            <input type="number" step="0.01" class="form-control" id="bobot" name="bobot" value="<?= $kriteria['bobot'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="sifat" class="form-label">Sifat Kriteria</label>
            <select class="form-control" id="sifat" name="sifat" required>
                <option value="benefit" <?= ($kriteria['sifat'] == 'benefit') ? 'selected' : '' ?>>Benefit</option>
                <option value="cost" <?= ($kriteria['sifat'] == 'cost') ? 'selected' : '' ?>>Cost</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="/kriteria" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection(); ?>