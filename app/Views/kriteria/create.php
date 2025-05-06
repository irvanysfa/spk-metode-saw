<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <h2>Tambah Kriteria</h2>
    <form action="<?= base_url('/kriteria/save') ?>" method="post">
        <div class="mb-3">
            <label for="kode_kriteria" class="form-label">Kode Kriteria</label>
            <input type="text" class="form-control" id="kode_kriteria" name="kode_kriteria" required>
        </div>

        <div class="mb-3">
            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
            <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" required>
        </div>

        <div class="mb-3">
            <label for="bobot" class="form-label">Bobot</label>
            <input type="number" step="0.01" class="form-control" id="bobot" name="bobot" required>
        </div>

        <div class="mb-3">
            <label for="sifat" class="form-label">Sifat Kriteria</label>
            <select class="form-control" id="sifat" name="sifat" required>
                <option value="benefit">Benefit</option>
                <option value="cost">Cost</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipe_kriteria" class="form-label">Tipe Kriteria</label>
            <select class="form-control" id="tipe_kriteria" name="tipe_kriteria" required>
                <option value="utama">Utama</option>
                <option value="tambahan">Tambahan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

</div>
<?= $this->endSection(); ?>