<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>
<div class="container-utama">
    <div class="container">
        <h2 class="mt-4">Perhitungan SAW</h2>

        <!-- Form Pilih Tahun Angkatan -->
        <form method="get" class="mb-4">
            <label class="form-label">Pilih Tahun Angkatan:</label>
            <select name="tahun_angkatan" class="form-select">
                <?php foreach ($tahun_angkatan as $t) : ?>
                    <option value="<?= $t['tahun_angkatan']; ?>" <?= (isset($_GET['tahun_angkatan']) && $_GET['tahun_angkatan'] == $t['tahun_angkatan']) ? 'selected' : ''; ?>>
                        <?= $t['tahun_angkatan']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Hitung</button>
        </form>

        <?php if (isset($hasil)) : ?>
            <!-- Kriteria Utama dengan Bobot Normalisasi -->
            <h4>Kriteria Utama dengan Bobot Normalisasi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Bobot Normalisasi</th>
                        <th>Sifat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kriteria as $k) : ?>
                        <?php if ($k['tipe_kriteria'] == 'utama') : ?>
                            <tr>
                                <td class="text-center"><?= $k['kode_kriteria']; ?></td>
                                <td><?= $k['nama_kriteria']; ?></td>
                                <td class="text-center"><?= $k['bobot']; ?></td>
                                <td class="text-center"><?= $k['bobot_normalisasi']; ?></td>
                                <td class="text-center"><?= ucfirst($k['sifat']); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Kriteria Tambahan dengan Bobot Normalisasi -->
            <h4>Kriteria Tambahan dengan Bobot Normalisasi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot</th>
                        <th>Bobot Normalisasi</th>
                        <th>Sifat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kriteria as $k) : ?>
                        <?php if ($k['tipe_kriteria'] == 'tambahan') : ?>
                            <tr>
                                <td class="text-center"><?= $k['kode_kriteria']; ?></td>
                                <td><?= $k['nama_kriteria']; ?></td>
                                <td class="text-center"><?= $k['bobot']; ?></td>
                                <td class="text-center"><?= $k['bobot_normalisasi']; ?></td>
                                <td class="text-center"><?= ucfirst($k['sifat']); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- 2. Matriks Keputusan -->
            <h4>Matriks Keputusan</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Alternatif</th>
                        <?php foreach ($kriteria as $k) : ?>
                            <th><?= $k['kode_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td class="text-center"><?= $s['kode_alternatif']; ?></td>
                            <?php foreach ($kriteria as $k) : ?>
                                <td class="text-center"><?= $nilai[$s['id_siswa']][$k['id_kriteria']] ?? 0; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <!-- 3. Tabel Nilai Maksimum dan Minimum -->
            <h4>Nilai Ma dan Min setiap Kriteria</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Kriteria</th>
                        <th>Nilai Maksimum</th>
                        <th>Nilai Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($max_min_nilai as $id_kriteria => $values): ?>
                        <tr>
                            <td class="text-center"><?= $id_kriteria ?></td>
                            <td class="text-center"><?= $values['max'] ?></td>
                            <td class="text-center"><?= $values['min'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <!-- 4. Normalisasi Nilai Siswa -->
            <h4>Normalisasi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode Alternatif</th>
                        <?php foreach ($kriteria as $k) : ?>
                            <th><?= $k['kode_kriteria']; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siswa as $s) : ?>
                        <tr>
                            <td class="text-center"><?= $s['kode_alternatif']; ?></td>
                            <?php foreach ($kriteria as $k) : ?>
                                <td class="text-center"><?= $normalisasi[$s['id_siswa']][$k['id_kriteria']] ?? 0; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h4>Normalisasi Kriteria x Bobot Kriteria</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Kode Alternatif</th> <!-- Ganti dari "Nama Siswa" -->
                    <?php foreach ($kriteria as $k): ?>
                        <th><?= $k['kode_kriteria'] ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($siswa as $s): ?>
                    <tr>
                        <td class="text-center"><?= $s['kode_alternatif'] ?></td> <!-- Ganti dari $s['nama_siswa'] -->
                        <?php foreach ($kriteria as $k): ?>
                            <td class="text-center">
                                <?= $perkalian[$s['id_siswa']][$k['id_kriteria']] ?? '-' ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>


            <h4>Hasil Perhitungan SAW</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Alternatif</th>
                        <th>Nama Siswa</th>
                        <th>Nilai Utama</th>
                        <th>Nilai Tambahan</th>
                        <th>Total Nilai</th>
                        <th>Ranking</th> <!-- Kolom tambahan -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // 1. Ambil total nilai per siswa
                    $total_nilai_array = [];
                    foreach ($hasil as $id_siswa => $nilai) {
                        $total_nilai_array[$id_siswa] = $nilai['total'];
                    }

                    // 2. Urutkan total nilai menurun untuk membuat ranking
                    arsort($total_nilai_array);

                    // 3. Buat array id_siswa => ranking
                    $ranking_array = [];
                    $ranking = 1;
                    foreach ($total_nilai_array as $id => $total) {
                        $ranking_array[$id] = $ranking++;
                    }

                    // 4. Tampilkan data asli ($hasil), ranking diambil dari $ranking_array
                    $no = 1;
                    foreach ($hasil as $id_siswa => $nilai) :
                        $siswa_data = $siswa[array_search($id_siswa, array_column($siswa, 'id_siswa'))];
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $siswa_data['kode_alternatif']; ?></td>
                            <td><?= $siswa_data['nama_siswa']; ?></td>
                            <td class="text-center"><?= $nilai['utama']; ?></td>
                            <td class="text-center"><?= $nilai['tambahan']; ?></td>
                            <td class="text-center"><?= $nilai['total']; ?></td>
                            <td class="text-center"><?= $ranking_array[$id_siswa]; ?></td> <!-- Ranking sebenarnya -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>