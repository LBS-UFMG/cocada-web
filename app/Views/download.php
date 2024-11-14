<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container py-5">

    <h1 class="pb-5 text-dark">Download</h1>

    <a href="<?= base_url('/data/rnapedia_database.tsv') ?>">RNApedia v1 - List of structures (TSV format; 3MB)</a>
</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
