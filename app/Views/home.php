<!-- modelo para criação de views: copie este arquivo e apague os comentários -->
<?= $this->extend('template') ?>

<?= $this->section('scripts') ?>
<!-- adicione links para scripts aqui -->
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<div class="container col-xxl-10 px-2 py-0">
  <div class="row flex-lg-row-reverse align-items-center g-5 py-4">
    <div class="col-10 col-sm-8 col-md-6">
      <img src="<?= base_url('/img/home.png') ?>" class="d-block mx-lg-auto img-fluid" width="450" loading="lazy">
    </div>
    <div class="col-md-6">
      <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">The Interatomic Contact Database & Tool</h1>

      <p class="lead">COCaDA-web is a tool and a database that presents contacts in all structures available in the PDB database. COCaDA calculates seven types of contacts: hydrogen bonds, hydrophobic, aromatic, attractive, repulsive, salt bridges and disulfide bridges. </p>

      <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-1">

        <a class="btn btn-primary btn-lg px-4 me-md-2 azul" href="#run">Run</button>
          <a href="#examples" class="btn btn-outline-dark btn-lg px-4 me-md-2">Examples</a>


      </div>
    </div>
  </div>
</div>

<div class="bg-light my-5 py-5">
  <div id="info" class="container">
    <div class="row">
      <div class="col-xs-12 col-md-3">
        <div class="card p-2" style="border-left: #031430 5px solid; color: #ccc">
          <div class="caption">
            <div class="row">
              <div class="col-md-3 text-dark" style="font-size: 72px">
                <i class="bi bi-braces-asterisk"></i>
              </div>
              <div class="col-md-9 text-end">
                <h3 class="mt-4">
                  <strong class="texto-azul">
                    733,012,478
                  </strong>
                </h3>
                <p class="text-muted small"><strong>CONTACTS</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="card p-2" style="border-left: #031430 5px solid; color: #ccc">
          <div class="caption">
            <div class="row">
              <div class="col-md-3 text-dark" style="font-size: 72px">
                <i class="bi bi-info-circle-fill"></i>
              </div>
              <div class="col-md-9 text-end">
                <h3 class="mt-4">
                  <strong class="texto-azul">
                    673,527,550
                  </strong>
                </h3>
                <p class="text-muted small"><strong>INTRA-CHAIN CONTACTS</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="card p-2" style="border-left: #031430 5px solid; color: #ccc">
          <div class="caption">
            <div class="row">
              <div class="col-md-3 text-dark" style="font-size: 72px">
                <i class="bi bi-exclude"></i>
              </div>
              <div class="col-md-9 text-end">
                <h3 class="mt-4"><strong class="texto-azul">
                  59,484,928
                  </strong>
                </h3>
                <p class="text-muted small"><strong>INTER-CHAIN CONTACTS</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <div class="card p-2" style="border-left: #031430 5px solid; color: #ccc">
          <div class="caption">
            <div class="row">
              <div class="col-md-3 text-dark" style="font-size: 72px">
                <i class="bi bi-hurricane"></i>
              </div>
              <div class="col-md-9 text-end">
                <h3 class="mt-4">
                  <strong class="texto-azul">
                    223,505
                  </strong>
                </h3>
                <p class="text-muted small"><strong>3D STRUCTURES</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h5 class="text-muted small">*Last updated on: Jan 2025</h5>
  </div>
</div>

<div class="container mt-5" id="run">
  <div class="row">
    <div class="col-xs-12 col-lg-12">
      <div class="alert alert-light shadow my-4 " style="border-left: #6cbd16 5px solid">
        <div class="caption">
          <div class="row">
            <div class="col-md-12 p-4">
              <h4 class="" style="color:#6cbd16"><strong>How to cite:</strong></h4>
              <p class="small" id="browse">LEMOS, Rafael P.; MARIANO, Diego; SILVEIRA, Sabrina A.; MELO-MINARDI, Raquel C. de. <strong>COCαDA - Large-Scale Protein Interatomic Contact Cutoff Optimization by Cα Distance Matrices.</strong> In: Proceedings of the XVII Brazilian Symposium on Bioinformatics (BSB), 17, p. 59-70, 2024. DOI: https://doi.org/10.5753/bsb.2024.245545
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ************************ RUN ************************ -->

<div class="container mt-5 border rounded p-5 bg-light">

  <h1><strong>Run COCαDA-web</strong></h1>
  <hr>
  <p class="pb-4 text-muted">
    There are two ways to run COCaDA-web: (1) Upload a file in PDB or CIF format; or (2) enter the 4-digit corresponding PDB code to access COCaDA-db pre-calculated structure contacts. COCaDA-db only supports PDB structures with up to 10,000 amino acid residues. To access structures with more than 10,000 residues, please upload your file.
  </p>
  <div class="row">
    <div class="col">
      <label class="badge text-bg-light">Submit your PDB file (limit 10MB)</label>

      <form action="<?php echo base_url('run'); ?>" method="post" enctype="multipart/form-data">
        <!-- <textarea placeholder="Paste PDB/CIF file here" class="form-control" name="pdb"></textarea> -->

        <div class="input-group">
          <input type="file" class="form-control" name="pdbfile" id="pdbfile" aria-describedby="run" aria-label="Upload">
          <button class="btn btn-success azul" type="submit" id="run">Run</button>
        </div>

      </form>

    </div>
    <div class="col border-start">
      <label class="badge text-bg-light">or type a PDB ID</label>
      <div class="input-group mb-3 w-50">
        <input type="text" id="pdb_go" class="form-control" placeholder="e.g., 2LZM" aria-label="PDB ID" aria-describedby="explore" onkeydown="redirectToURL2(event)">
        <button class="btn btn-outline-secondary" type="button" id="go">Go</button>
      </div>
    </div>
  </div>
</div>

<!-- ************************ EXAMPLES ************************ -->

<div class="container mt-5 my-5 px-5 pb-5" id="examples">
  <h1 class="pt-5"><strong>Examples</strong></h1>
  <hr>
  <p class="text-muted">Click on one of the following PDB-IDs to explore the corresponding entry:</p>
  <div class="row">
    <div class="col">
      <label class="badge bg-light text-dark">Protein single-chain</label>
      <a href="<?= base_url('/entry/1K0P') ?>" class="badge bg-primary azul">1K0P</a>
      <a href="<?= base_url('/entry/2LZM') ?>" class="badge bg-primary azul">2LZM</a>
      <a href="<?= base_url('/entry/4MDP') ?>" class="badge bg-primary azul">4MDP</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label class="badge bg-light text-dark">Protein multi-chain complex</label>
      <a href="<?= base_url('/entry/1SHR') ?>" class="badge bg-primary azul">1SHR</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label class="badge bg-light text-dark">Protein-peptide</label>
      <a href="<?= base_url('/entry/1A1M') ?>" class="badge bg-primary azul">1A1M</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label class="badge bg-light text-dark">Protein-DNA</label>
      <a href="<?= base_url('/entry/3L1P') ?>" class="badge bg-primary azul">3L1P</a>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <label class="badge bg-light text-dark">Protein-RNA</label>
      <a href="<?= base_url('/entry/4PMI') ?>" class="badge bg-primary azul">4PMI</a>
    </div>
  </div>
</div>

<script>
  const go = document.getElementById('go');

  go.addEventListener('click', () => {
    let url = document.getElementById('pdb_go').value;
    url = url.toUpperCase();
    if (url) {
      if (url.length != 4) {
        window.location.href = '<?= base_url("/entry/404") ?>';
      }
      window.location.href = '<?= base_url() ?>entry/' + url;
    }
  });

  function redirectToURL2(event) {
    // Verificar se a tecla pressionada foi Enter (código 13)
    if (event.keyCode === 13) {
      event.preventDefault(); // Prevenir o envio do formulário
      let url = document.getElementById('pdb_go').value;
      url = url.toUpperCase();
      if (url) {
        if (url.length != 4) {
          window.location.href = '<?= base_url("/entry/404") ?>';
        }
        window.location.href = '<?= base_url() ?>entry/' + url;
      }
    }
  }
</script>

<?= $this->endSection() ?>