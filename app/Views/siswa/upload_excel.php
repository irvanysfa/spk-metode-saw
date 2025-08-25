<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-utama">
    <form action="<?= base_url('import/excel') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="fileexcel" required>
        <button type="submit" class='btn btn-primary'>Upload</button>
    </form>
</div>
<?= $this->endSection() ?>