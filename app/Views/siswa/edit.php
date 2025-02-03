<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Siswa</h2>

<form action="<?= base_url('/siswa/update/' . $siswa['id_siswa']) ?>" method="post">
    <div class="form-group">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa" value="<?= $siswa['nama_siswa'] ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="nomor_absen" class="form-label">Nomor Absen</label>
        <input type="number" class="form-control" id="nomor_absen" name="nomor_absen" value="<?= $siswa['nomor_absen'] ?>" required>
    </div>

    <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" value="<?= $siswa['kelas'] ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success mt-2">Simpan</button>
    <a href="<?= base_url('/siswa') ?>" class="btn btn-secondary mt-2">Kembali</a>
</form>

<?= $this->endSection() ?>