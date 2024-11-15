<!-- modelo para criação de views: copie este arquivo e apague os comentários -->
<?= $this->extend('template') ?>

<?= $this->section('scripts') ?>
<!-- adicione links para scripts aqui -->
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<div class="container col-xxl-10 px-2 py-0">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-4">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="<?= base_url('/img/home.png') ?>" class="d-block mx-lg-auto img-fluid" width="450" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Calculate contacts</h1>

            <p class="lead">Insert a PDB or CIF file to calculate contacts using COCaDA algorithm. </p>
            
            <form action="<?php echo base_url('run'); ?>" method="post" enctype="multipart/form-data">
                <textarea placeholder="Paste PDB/CIF file here" class="form-control" name="pdb"></textarea>

                <input type="file" name="pdb_file" disabled>

                <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-5">
                    <button type="submit"  class="btn btn-primary btn-lg px-4 me-md-2 azul">Run COCaDA now</button>
                    <a href="http://bioinfo.dcc.ufmg.br/coda" class="btn btn-outline-secondary btn-lg px-4 me-md-2">Explore CODA</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-xs-12 col-lg-12">
            <div class="alert alert-light shadow my-4 " style="border-left: #472910 5px solid">
                <div class="caption">
                    <div class="row">
                        <div class="col-md-12 p-4">
                            <h4 class="" style="color:#472910"><strong>How to cite:</strong></h4>
                            <p class="small" id="browse">Lemos et al. COCaDA-Web. Software. Laboratory of Bioinformatics and Systems. Universidade Federal de Minas Gerais. 2024.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row bg-light mt-5 px-2" id="explore">

</div>

<?= $this->endSection() ?>