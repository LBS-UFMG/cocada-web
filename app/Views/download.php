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
                <td><a href="https://doi.org/10.5281/zenodo.14834858" target="_blank">10.5281/zenodo.14834858</a></td>
            </tr>

            <tr>
                <td><b>COCADA-CLI v1.0</b></td>
                <td>20KB</td>
                <td>COCADA command line tool (Python source code).</td>
                <td><a href="https://github.com/LBS-UFMG/COCaDA/archive/refs/tags/v1.0.zip" target="_blank">github.com/LBS-UFMG/cocada</a></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
