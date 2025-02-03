<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>
<div class="container-utama">
    <h2>Hasil Perankingan</h2>

    <form method="get" action="<?= base_url('hasil') ?>">
        <label for="kelas">Pilih Kelas:</label>
        <select name="kelas" id="kelas" class="form-control" onchange="this.form.submit()">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($kelas_list as $k) : ?>
                <option value="<?= $k['kelas']; ?>" <?= ($kelasTerpilih == $k['kelas']) ? 'selected' : ''; ?>>
                    <?= $k['kelas']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($kelasTerpilih)) : ?>
        <h4>Hasil Perankingan Kelas: <?= $kelasTerpilih; ?></h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama Siswa</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasil as $h) : ?>
                    <tr>
                        <td><?= $h['ranking']; ?></td>
                        <td><?= $h['nama_siswa']; ?></td>
                        <td><?= $h['total_nilai']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- Tombol Cetak PDF -->
    <?php if (!empty($hasil)) : ?>
        <a href="<?= base_url('hasil/print_pdf?kelas=' . $_GET['kelas']); ?>" target="_blank">
            <button class="btn btn-success mt-2">Cetak PDF</button>
        </a>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>