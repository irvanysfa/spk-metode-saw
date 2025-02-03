<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h2>Edit Nilai</h2>
<form action="<?= base_url('/nilai/update/' . $nilai['id_nilai']) ?>" method="post">
    <div class="mb-3">
        <label for="nilai" class="form-label">Nilai</label>
        <input type="number" class="form-control" name="nilai" value="<?= $nilai['nilai'] ?>" step="0.01" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('/nilai') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
