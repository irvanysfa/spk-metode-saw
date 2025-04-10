<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Tambah Siswa</h2>

<form action="<?= base_url('/siswa/store') ?>" method="post">
    <div class="form-group">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="kode_alternatif" class="form-label">Kode Alternatif</label>
        <input type="text" class="form-control" id="kode_alternatif" name="kode_alternatif" placeholder="Misal: A01" required>
    </div>

    <div class="form-group">
        <label>Kelas</label>
        <select name="kelas" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach (range('A', 'H') as $huruf): ?>
                <option value="IX <?= $huruf ?>">IX <?= $huruf ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="tahun_angkatan">Tahun Angkatan</label>
        <input type="number" name="tahun_angkatan" id="tahun_angkatan" class="form-control" required placeholder="Contoh: 2023">
    </div>

    <button type="submit" class="btn btn-success mt-2">Simpan</button>
    <a href="<?= base_url('/siswa') ?>" class="btn btn-secondary mt-2">Kembali</a>
</form>

<?= $this->endSection() ?>