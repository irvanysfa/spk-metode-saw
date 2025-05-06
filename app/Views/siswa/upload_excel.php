<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('import/excel') ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileexcel" required>
    <button type="submit">Upload</button>
</form>

<?= $this->endSection() ?>