<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container py-5 text-secondary">
    <h1 style="font-size:100px;">Error 404</h1>
    <p>Project not found in COCaDA-web.</p>
    <p><strong>A COCADA-ID has six characters, <em>e.g.</em>, 1ABCDE</p>

    <img src="<?= base_url('/img/cocadito2.png') ?>" width="300px">

</div>

<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
