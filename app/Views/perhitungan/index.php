<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>
<div class="container-utama">
    <div class="container">
        <h2 class="mt-4">Perhitungan SAW</h2>

        <!-- Form Pilih Kelas -->
        <form method="get" class="mb-4">
            <label class="form-label">Pilih Kelas:</label>
            <select name="kelas" class="form-select">
                <?php foreach ($kelas as $k) : ?>
                    <option value="<?= $k['kelas']; ?>" <?= (isset($_GET['kelas']) && $_GET['kelas'] == $k['kelas']) ? 'selected' : ''; ?>>
                        <?= $k['kelas']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Hitung</button>
        </form>

        <?php if (isset($hasil)) : ?>

            <!-- Tabel Kriteria -->
            <h4>Kriteria dengan Bobot Normalisasi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Bobot Normalisasi</th>
                        <th>Sifat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kriteria as $k) : ?>
                        <tr>
                            <td><?= $k['id_kriteria']; ?></td>
                            <td><?= $k['nama_kriteria']; ?></td>
                            <td><?= $k['bobot']; ?></td>
                            <td><?= $k['bobot_normalisasi']; ?></td>
                            <td><?= ucfirst($k['sifat']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Tabel Nilai Siswa per Kriteria -->
            <h4>Nilai Siswa per Kriteria</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <?php foreach ($kriteria as $k) : ?>
                            <th><?= $k['nama_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $s['nama_siswa']; ?></td>
                            <?php foreach ($kriteria as $k) : ?>
                                <td><?= $nilai[$s['id_siswa']][$k['id_kriteria']] ?? 0; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Tabel Nilai Maksimum dan Minimum -->
            <h4>Nilai Maksimum dan Minimum per Kriteria</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Nilai Maksimum</th>
                        <th>Nilai Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($max_min_nilai as $id_kriteria => $values): ?>
                        <tr>
                            <td><?= $id_kriteria ?></td>
                            <td><?= $kriteria[array_search($id_kriteria, array_column($kriteria, 'id_kriteria'))]['nama_kriteria'] ?></td>
                            <td><?= $values['max'] ?></td>
                            <td><?= $values['min'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Tabel Normalisasi Nilai Siswa -->
            <h4>Normalisasi Nilai Siswa</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <?php foreach ($kriteria as $k) : ?>
                            <th><?= $k['nama_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $s['nama_siswa']; ?></td>
                            <?php foreach ($kriteria as $k) : ?>
                                <td><?= $normalisasi[$s['id_siswa']][$k['id_kriteria']] ?? 0; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Tabel Hasil Perhitungan SAW -->
            <h4>Hasil Perhitungan SAW</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rank = 1;
                    foreach ($hasil as $id_siswa => $nilai) : ?>
                        <tr>
                            <td><?= $rank++; ?></td>
                            <td><?= $siswa[array_search($id_siswa, array_column($siswa, 'id_siswa'))]['nama_siswa']; ?></td>
                            <td><?= $nilai; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>