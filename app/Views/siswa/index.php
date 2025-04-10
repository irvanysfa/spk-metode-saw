<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-utama">
    <h2>Data Siswa</h2>
    <a href="<?= base_url('/siswa/create') ?>" class="btn btn-primary">Tambah Siswa</a>
    <form method="get" action="<?= base_url('/siswa') ?>" class="row row-cols-lg-auto g-3 align-items-center mt-3">
        <div class="col-12">
            <label for="kelas" class="form-label">Pilih Kelas:</label>
            <select name="kelas" id="kelas" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                <?php
                $kelasList = ['IX A', 'IX B', 'IX C', 'IX D', 'IX E', 'IX F', 'IX G', 'IX H'];
                foreach ($kelasList as $kls): ?>
                    <option value="<?= $kls ?>" <?= (isset($_GET['kelas']) && $_GET['kelas'] == $kls) ? 'selected' : '' ?>><?= $kls ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <label for="angkatan" class="form-label">Tahun Angkatan:</label>
            <select name="angkatan" id="angkatan" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Angkatan</option>
                <?php foreach ($angkatanList as $a): ?>
                    <option value="<?= $a['tahun_angkatan'] ?>" <?= (isset($_GET['angkatan']) && $_GET['angkatan'] == $a['tahun_angkatan']) ? 'selected' : '' ?>>
                        <?= $a['tahun_angkatan'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>


    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tahun Angkatan</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $s['kode_alternatif'] ?></td>
                    <td><?= $s['nama_siswa'] ?></td>
                    <td><?= $s['kelas'] ?></td>
                    <td><?= $s['tahun_angkatan'] ?></td>
                    <td>
                        <?php foreach ($kriteria as $k): ?>
                            <?php
                            $nilai_kriteria = '-';
                            foreach ($s['nilai'] as $n) {
                                if ($n['id_kriteria'] == $k['id_kriteria']) {
                                    $nilai_kriteria = $n['nilai'];
                                    break;
                                }
                            }
                            ?>
                            <span class='badge bg-info'><?= $k['nama_kriteria'] ?>: <?= $nilai_kriteria ?></span><br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('/siswa/edit/' . $s['id_siswa']) ?>" class="btn btn-warning btn-sm">Edit Siswa</a>
                        <a href="<?= base_url('/siswa/edit-nilai/' . $s['id_siswa']) ?>" class="btn btn-success btn-sm">Edit Nilai</a>
                        <a href="<?= base_url('/siswa/delete/' . $s['id_siswa']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Tambahkan library SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "<?= session()->getFlashdata('error'); ?>",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "<?= session()->getFlashdata('success'); ?>",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

<?= $this->endSection() ?>