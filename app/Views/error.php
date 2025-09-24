<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container py-5 text-secondary">
    <div class="row">
        <div class="col-3">
            <img src="<?= base_url('/img/cocadito2.png') ?>" width="300px" class="rounded">
        </div>
        <div class="col">
            <h1 style="font-size:100px;">Error</h1>
            <p>An error occurred while processing your request. Please try again later or contact the system administrators.</p>

            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error log:</h4>
                <i class="bi bi-exclamation-circle-fill"></i>
                <?=$details?>
            </div>
        </div>
    </div>
</div>

<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>