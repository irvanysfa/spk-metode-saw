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

        <!-- Tombol Hapus Data -->
        <form id="deleteForm" method="post" action="<?= base_url('hasil/deleteByKelas'); ?>">
            <input type="hidden" name="kelas" value="<?= $kelasTerpilih; ?>">
            <button type="button" class="btn btn-danger mt-2" onclick="confirmDelete()">Hapus Data</button>
        </form>

        <!-- Tombol Cetak PDF -->
        <a href="<?= base_url('hasil/print_pdf?kelas=' . $kelasTerpilih); ?>" target="_blank">
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
            text: "Data hasil perhitungan untuk kelas ini akan dihapus!",
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

    // Tampilkan notifikasi sukses atau error
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire("Berhasil!", "<?= session()->getFlashdata('success'); ?>", "success");
    <?php elseif (session()->getFlashdata('error')) : ?>
        Swal.fire("Gagal!", "<?= session()->getFlashdata('error'); ?>", "error");
    <?php endif; ?>
</script>

<?= $this->endSection(); ?>
