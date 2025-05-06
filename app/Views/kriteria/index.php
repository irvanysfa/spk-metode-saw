<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-utama">
    <h2>Data Kriteria</h2>

    <a href="<?= base_url('/kriteria/create') ?>" class="btn btn-primary">Tambah Kriteria</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Kriteria</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Sifat</th>
                <th>Tipe</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($kriteria as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="text-center"><?= esc($k['kode_kriteria']) ?></td>
                    <td><?= esc($k['nama_kriteria']) ?></td>
                    <td class="text-center"><?= esc($k['bobot']) ?></td>
                    <td class="text-center"><?= esc($k['sifat']) ?></td>
                    <td class="text-center"><?= esc($k['tipe_kriteria']) ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('/kriteria/edit/' . $k['id_kriteria']) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= base_url('/kriteria/delete/' . $k['id_kriteria']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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