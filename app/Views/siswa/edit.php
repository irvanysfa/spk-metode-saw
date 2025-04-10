<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Siswa</h2>

<form action="<?= base_url('/siswa/update/' . $siswa['id_siswa']) ?>" method="post">
    <div class="form-group">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa" value="<?= $siswa['nama_siswa'] ?>" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="kode_alternatif" class="form-label">Kode Alternatif</label>
        <input type="text" class="form-control" id="kode_alternatif" name="kode_alternatif" value="<?= $siswa['kode_alternatif'] ?>" required>
    </div>

    <div class="form-group">
        <label>Kelas</label>
        <select name="kelas" class="form-control" required>
            <option value="">-- Pilih Kelas --</option>
            <?php foreach (range('A', 'H') as $huruf):
                $kelas = 'IX ' . $huruf;
            ?>
                <option value="<?= $kelas ?>" <?= ($siswa['kelas'] == $kelas) ? 'selected' : '' ?>><?= $kelas ?></option>
            <?php endforeach; ?>
        </select>
    </div>


    <div class="form-group">
        <label for="tahun_angkatan">Tahun Angkatan</label>
        <input type="number" name="tahun_angkatan" id="tahun_angkatan" class="form-control" value="<?= $siswa['tahun_angkatan'] ?>" required>
    </div>

    <button type="submit" class="btn btn-success mt-2">Simpan</button>
    <a href="<?= base_url('/siswa') ?>" class="btn btn-secondary mt-2">Kembali</a>
</form>

<?= $this->endSection() ?>