<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container-fluid py-5">

    <h1 class="pb-5 text-dark">Download</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>File</th>
                <th>Size</th>
                <th>Description</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>cocada_2025_01_22.zip</b></td>
                <td>4.6GB</td>
                <td>List of contacts in CSV files sorted by structure.</td>
                <td><a href="https://doi.org/10.5281/zenodo.14714421" target="_blank">10.5281/zenodo.14714421</a></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
