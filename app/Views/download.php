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
                <td><b>cocada-web_20260401.zip</b></td>
                <td>4.6GB</td>
                <td>Contacts for 243,382 structures (asymmetric units) from the PDB (update: April 1st, 2026).</td>
                <td><a href="https://doi.org/10.5281/zenodo.14714420" target="_blank">10.5281/zenodo.14714420</a></td>
            </tr>

            <tr>
                <td><b>biologicalassemblies_cocada-web_20260401.zip</b></td>
                <td>1.5GB</td>
                <td>Contacts for 83,214 biological assemblies (only Biological Assembly 1) from the PDB (update: April 1st, 2026).</td>
                <td><a href="https://doi.org/10.5281/zenodo.14714420" target="_blank">10.5281/zenodo.14714420</a></td>
            </tr>

            <tr>
                <td><b>COCaDA v1.6</b></td>
                <td>26KB</td>
                <td>COCaDA command line tool (Python source code).</td>
                <td><a href="https://github.com/LBS-UFMG/COCaDA/archive/refs/tags/v1.6.zip" target="_blank">github.com/LBS-UFMG/cocada</a></td>
            </tr>
        </tbody>
    </table>
</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
