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
            <div class="accordion" id="accordionPerhitungan">
                <!-- Kriteria Utama -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingUtama">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUtama" aria-expanded="true" aria-controls="collapseUtama">
                            Kriteria Utama dengan Bobot Normalisasi
                        </button>
                    </h2>
                    <div id="collapseUtama" class="accordion-collapse collapse show" aria-labelledby="headingUtama" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
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
                        </div>
                    </div>
                </div>

                <!-- Kriteria Tambahan -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTambahan">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTambahan" aria-expanded="false" aria-controls="collapseTambahan">
                            Kriteria Tambahan dengan Bobot Normalisasi
                        </button>
                    </h2>
                    <div id="collapseTambahan" class="accordion-collapse collapse" aria-labelledby="headingTambahan" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
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
                        </div>
                    </div>
                </div>

                <!-- Matriks Keputusan -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMatriks">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMatriks" aria-expanded="false" aria-controls="collapseMatriks">
                            Matriks Keputusan
                        </button>
                    </h2>
                    <div id="collapseMatriks" class="accordion-collapse collapse" aria-labelledby="headingMatriks" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
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
                        </div>
                    </div>
                </div>

                <!-- Nilai Max Min -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingMaxMin">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMaxMin" aria-expanded="false" aria-controls="collapseMaxMin">
                            Nilai Maksimum dan Minimum
                        </button>
                    </h2>
                    <div id="collapseMaxMin" class="accordion-collapse collapse" aria-labelledby="headingMaxMin" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
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
                                            <td class="text-center"><?= $values['kode_kriteria'] ?></td>
                                            <td class="text-center"><?= $values['max'] ?></td>
                                            <td class="text-center"><?= $values['min'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Normalisasi -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNormalisasi">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNormalisasi" aria-expanded="false" aria-controls="collapseNormalisasi">
                            Normalisasi Nilai Siswa
                        </button>
                    </h2>
                    <div id="collapseNormalisasi" class="accordion-collapse collapse" aria-labelledby="headingNormalisasi" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
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
                        </div>
                    </div>
                </div>

                <!-- Normalisasi * Bobot -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPerkalian">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePerkalian" aria-expanded="false" aria-controls="collapsePerkalian">
                            Normalisasi x Bobot
                        </button>
                    </h2>
                    <div id="collapsePerkalian" class="accordion-collapse collapse" aria-labelledby="headingPerkalian" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Kode Alternatif</th>
                                    <?php foreach ($kriteria as $k): ?>
                                        <th><?= $k['kode_kriteria'] ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <?php foreach ($siswa as $s): ?>
                                    <tr>
                                        <td class="text-center"><?= $s['kode_alternatif'] ?></td>
                                        <?php foreach ($kriteria as $k): ?>
                                            <td class="text-center">
                                                <?= $perkalian[$s['id_siswa']][$k['id_kriteria']] ?? '-' ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hasil Perhitungan -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingHasil">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHasil" aria-expanded="false" aria-controls="collapseHasil">
                            Hasil Akhir dan Ranking
                        </button>
                    </h2>
                    <div id="collapseHasil" class="accordion-collapse collapse" aria-labelledby="headingHasil" data-bs-parent="#accordionPerhitungan">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Alternatif</th>
                                        <th>Nama Siswa</th>
                                        <th>Nilai Utama</th>
                                        <th>Nilai Tambahan</th>
                                        <th>Total Nilai</th>
                                        <th>Ranking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_nilai_array = [];
                                    foreach ($hasil as $id_siswa => $nilai) {
                                        $total_nilai_array[$id_siswa] = $nilai['total'];
                                    }
                                    arsort($total_nilai_array);
                                    $ranking_array = [];
                                    $ranking = 1;
                                    foreach ($total_nilai_array as $id => $total) {
                                        $ranking_array[$id] = $ranking++;
                                    }
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
                                            <td class="text-center"><?= $ranking_array[$id_siswa]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>