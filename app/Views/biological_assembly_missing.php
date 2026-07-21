<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12 text-center">

            <img src="<?= base_url('/img/cocadito-loading.png') ?>" width="140" class="mb-4" alt="COCaDA">

            <h2 class="mb-3">
                <strong><?= esc($id) ?></strong> &mdash; Biological assembly
            </h2>

            <div class="alert alert-warning d-inline-block px-4 py-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                No biological assembly is available for this structure.
            </div>

            <p class="text-muted mt-3">
                The biological assembly data for <strong><?= esc($id) ?></strong> could not be found.
                You can go back to the main structure page.
            </p>

            <a href="<?= base_url("/entry/$id") ?>" class="btn btn-primary mt-2">
                <i class="bi bi-arrow-return-left"></i> Back to main structure
            </a>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
