<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-utama">
    <h2>Data Siswa</h2>
    <a href="<?= base_url('/siswa/create') ?>" class="btn btn-primary">Tambah Siswa</a>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
    Upload Excel
</button>
<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadModalLabel">Upload File Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('import/excel') ?>" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="formFile" class="form-label">Pilih file Excel</label>
            <input class="form-control" type="file" name="fileexcel" id="formFile" required>
          </div>
          <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>

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

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Alternatif</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>TA</th>
                <th>Nilai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($siswa as $s): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-center"><?= $s['kode_alternatif'] ?></td>
                    <td><?= $s['nama_siswa'] ?></td>
                    <td class="text-center"><?= $s['kelas'] ?></td>
                    <td class="text-center"><?= $s['tahun_angkatan'] ?></td>
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
                            <span class="badge" style="background-color: transparent; color: black;">
                                <?= $k['nama_kriteria'] ?>: <?= $nilai_kriteria ?>
                            </span>
                            <br>
                        <?php endforeach; ?>
                    </td>
                    <td class="text-center">
                        <a href="<?= base_url('/siswa/edit/' . $s['id_siswa']) ?>" class="btn btn-warning btn-sm custom-margin">Edit Siswa</a>
                        <a href="<?= base_url('/siswa/edit-nilai/' . $s['id_siswa']) ?>" class="btn btn-success btn-sm custom-margin">Edit Nilai</a>
                        <a href="<?= base_url('/siswa/delete/' . $s['id_siswa']) ?>" class="btn btn-danger btn-sm custom-margin" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>