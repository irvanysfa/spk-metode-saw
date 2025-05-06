<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container-utama">
    <h2>Hasil Perankingan</h2>

    <form method="get" action="<?= base_url('hasil') ?>">
        <label for="tahun_angkatan">Pilih Tahun Angkatan:</label>
        <select name="tahun_angkatan" id="tahun_angkatan" class="form-control" onchange="this.form.submit()">
            <option value="">-- Pilih Tahun Angkatan --</option>
            <?php foreach ($tahun_list as $t) : ?>
                <option value="<?= $t['tahun_angkatan']; ?>" <?= ($tahunTerpilih == $t['tahun_angkatan']) ? 'selected' : ''; ?>>
                    <?= $t['tahun_angkatan']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($tahunTerpilih)) : ?>
        <h4>Hasil Perankingan Tahun Angkatan: <?= $tahunTerpilih; ?></h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nilai Utama</th>
                    <th>Nilai Tambahan</th>
                    <th>Total Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hasil as $h) : ?>
                    <tr>
                        <td class="text-center"><?= $h['ranking']; ?></td>
                        <td><?= $h['nama_siswa']; ?></td>
                        <td class="text-center"><?= $h['kelas']; ?></td>
                        <td class="text-center"><?= $h['nilai_utama']; ?></td>
                        <td class="text-center"><?= $h['nilai_tambahan']; ?></td>
                        <td class="text-center"><?= $h['total_nilai']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tombol Hapus Data -->
        <form id="deleteForm" method="post" action="<?= base_url('hasil/deleteByTahun'); ?>">
            <input type="hidden" name="tahun_angkatan" value="<?= $tahunTerpilih; ?>">
            <button type="button" class="btn btn-danger mt-2" onclick="confirmDelete()">Hapus Data</button>
        </form>

        <!-- Tombol Cetak PDF -->
        <a href="<?= base_url('hasil/print_pdf?tahun_angkatan=' . $tahunTerpilih); ?>" target="_blank">
            <button class="btn btn-success mt-2">Cetak PDF</button>
        </a>
    <?php endif; ?>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data hasil perhitungan untuk tahun ini akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("deleteForm").submit();
            }
        });
    }

    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire("Berhasil!", "<?= session()->getFlashdata('success'); ?>", "success");
    <?php elseif (session()->getFlashdata('error')) : ?>
        Swal.fire("Gagal!", "<?= session()->getFlashdata('error'); ?>", "error");
    <?php endif; ?>
</script>

<?= $this->endSection(); ?>