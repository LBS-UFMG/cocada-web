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
        <a class="btn btn-primary btn-lg px-4 me-md-2 azul" href="#run">Run</a>
        <a href="#examples" class="btn btn-outline-dark btn-lg px-4 me-md-2">Examples</a>
      </div>
    </div>
  </div>
</div>

<div class="bg-light my-5 py-5" style="margin-left:-10px; width:calc(100% + 20px);">
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
                    <?= $h1 ?>
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
                    <?= $h2 ?>
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
                    <?= $h3 ?>
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
                    <?= $h4 ?>
                  </strong>
                </h3>
                <p class="text-muted small"><strong>3D STRUCTURES</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <h5 class="text-muted small">*Last updated on: <?= $update ?></h5>
  </div>
</div>

<div class="container mt-5" id="cite">
  <div class="row">
    <div class="col-xs-12 col-lg-12">
      <div class="alert alert-light shadow my-4 " style="border-left: #6cbd16 5px solid">
        <div class="caption">
          <div class="row">
            <div class="col-md-12 p-4">
              <h4 class="" style="color:#6cbd16"><strong>How to cite:</strong></h4>

              <label class="badge bg-success azul mt-2"><i class="bi bi-star-fill me-1"></i>Main article (2025)</label>
              <p class="small">Lemos RP, Mariano D, Silveira SDA and de Melo-Minardi RC (2025) <strong>COCαDA - a fast and scalable algorithm for interatomic contact detection in proteins using Cα distance matrices</strong>. Front. Bioinform. 5:1630078. doi: <a href="https://doi.org/10.3389/fbinf.2025.1630078">10.3389/fbinf.2025.1630078</a></p>

              <label class="badge bg-success azul mt-3">Conference paper (2024)</label>  
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

<div class="container mt-5 border rounded p-5 bg-light" id="run">

  <h1><strong>Run COCαDA-web</strong></h1>
  <hr>
  <p class="pb-4 text-muted small">
    <strong>There are three ways to run COCaDA-web</strong> (1) Upload a file in PDB or CIF format; (2) enter the PDB/UniProt code to download data from PDB/AlphaFoldDB API; (3) use the search bar to access COCaDA-db pre-calculated structure contacts. COCaDA-db only supports PDB structures with up to 10,000 amino acid residues. To access structures with more than 10,000 residues, please upload your file.
  </p>
  <div class="row">
    <div class="col-12 col-md-6 mt-2">
      <label class="badge bg-dark">Submit a PDB file <a class="link-success" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Limit 10MB"><i class="bi bi-question-circle-fill"></i></a></label>

      <form action="<?php echo base_url('run'); ?>" method="post" enctype="multipart/form-data">
        <div class="input-group">
          <input type="file" class="form-control  form-control-lg" name="pdbfile" id="pdbfile" aria-describedby="run" aria-label="Upload">
        </div>
    </div>
    <div class="col-12 col-md-6 border-start pb-3 mt-2">
      <label class="badge bg-dark">or type a PDB ID or an UniProt/AlphaFoldDB ID <a class="link-success" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="You can enter a 4-character PDB code to download a file from the Protein Data Bank API (for a list of available PDB files, visit: https://www.rcsb.org). Optionally, you can enter a UniProt code to download an entry directly from the AlphaFoldDB API (for a list of available entries, visit: https://alphafold.ebi.ac.uk)."><i class="bi bi-question-circle-fill"></i></a></label>
      <div class="input-group mb-3 w-50">
        <input type="text" id="pdb_via_api" class="form-control form-control-lg" placeholder="e.g.: 2LZM or P04637" aria-label="PDB ID" aria-describedby="explore" name="pdb_via_api"> 
      </div>
    </div>
  </div>

  <!-- advanced options -->
  <div class="accordion" id="adv_opt">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Advanced options <a class="ms-2 link-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Click here only if you want to change the default parameters used by COCaDA for calculating contacts. If you want to run with the parameters recommended by the developers, just click on the 'Calculate contacts' button below."><i class="bi bi-question-circle-fill"></i></a>
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#adv_opt">
        <div class="accordion-body text-muted small">

          <div class="row">
            <div class="col p-4">

              <h4>Cutoffs</h4>
              <p>Change contact cutoff values (check default values <a target="_blank" href="<?= base_url('/documentation/#cutoff_values') ?>">here</a>):</p>

              <div class="row">
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-success">Hydrogen bonds</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minhb">Min</span>
                    <input type="text" class="form-control" placeholder="0" value="0" aria-label="min" aria-describedby="minhb" name="minhb">
                    <span class="input-group-text" id="maxhb">Max</span>
                    <input type="text" class="form-control" placeholder="3.9" value="3.9" aria-label="max" aria-describedby="maxhb" name="maxhb">
                  </div>


                </div>
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-light">Disulfide Bond</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minds">Min</span>
                    <input type="text" class="form-control" placeholder="0" value="0" aria-label="min" aria-describedby="minds" name="minds">
                    <span class="input-group-text" id="maxds">Max</span>
                    <input type="text" class="form-control" placeholder="2.8" value="2.8" aria-label="max" aria-describedby="maxds" name="maxds">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-warning">Hydrophobic</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minhy">Min</span>
                    <input type="text" class="form-control" placeholder="2" value="2" aria-label="min" aria-describedby="minhy" name="minhy">
                    <span class="input-group-text" id="maxhy">Max</span>
                    <input type="text" class="form-control" placeholder="4.5" value="4.5" aria-label="max" aria-describedby="maxhy" name="maxhy">
                  </div>


                </div>
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-danger">Repulsive</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minre">Min</span>
                    <input type="text" class="form-control" placeholder="2" value="2" aria-label="min" aria-describedby="minre" name="minre">
                    <span class="input-group-text" id="maxre">Max</span>
                    <input type="text" class="form-control" placeholder="6" value="6" aria-label="max" aria-describedby="maxre" name="maxre">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-md-6">

                  <span class="badge text-bg-info">Attractive</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minat">Min</span>
                    <input type="text" class="form-control" placeholder="3.9" value="3.9" aria-label="min" aria-describedby="minat" name="minat">
                    <span class="input-group-text" id="maxat">Max</span>
                    <input type="text" class="form-control" placeholder="6" value="6" aria-label="max" aria-describedby="maxat" name="maxat">
                  </div>


                </div>
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-primary">Salt Bridge</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minsb">Min</span>
                    <input type="text" class="form-control" placeholder="0" value="0" aria-label="min" aria-describedby="minsb" name="minsb">
                    <span class="input-group-text" id="maxsb">Max</span>
                    <input type="text" class="form-control" placeholder="3.9" value="3.9" aria-label="max" aria-describedby="maxsb" name="maxsb">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 col-md-6">
                  <span class="badge text-bg-secondary">Aromatic Stacking</span>

                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="minas">Min</span>
                    <input type="text" class="form-control" placeholder="2" value="2" aria-label="min" aria-describedby="minas" name="minas">
                    <span class="input-group-text" id="maxas">Max</span>
                    <input type="text" class="form-control" placeholder="5" value="5" aria-label="max" aria-describedby="maxas" name="maxas">
                  </div>
                </div>
              </div>
            </div>

            <div class="col border-start p-4">

              <h4>Filter chains</h4>
              <p>Select the chains you want to calculate contacts for.</p>
              <input type="radio" value="all" name="filter_chains" checked> All <br>
              <input type="radio" value="inter" name="filter_chains"> Only interchain contacts <br>
              <!-- <input type="radio" value="intra" name="filter_chains"> Only intrachain contacts<br> -->
              <input type="radio" value="chains" name="filter_chains" id="rchains"> Only contacts in the chains: <input type="text" placeholder="A,B,C" name="chains" disabled>

              <h4 class="mt-5">pH</h4>
              <p>Change the pH value (default is 7.4):</p>
              <input id="ph" type="range" min="0" max="14" step="0.1" name="ph" value="7.4" class="form-range">
              <p id="nameph" class="text-center text-muted">7.4</p>

              <input type="checkbox" value="ph_from_file" name="ph_from_file"> Use the pH value defined in the CIF/PDB file

              <script>
                $(document).ready(function() {
                  $('#ph').on('input', function() {
                    $('#nameph').text($('#ph').val());
                  });
                  $('#rchains').on('click', function() {
                    $('[name="chains"]').removeAttr('disabled');
                  });

                });
              </script>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <button class="btn btn-success azul btn-lg  w-100 mt-5 p-3 mb-3" type="submit" id="run">Calculate contacts</button>

  </form>

</div>

<!-- ************************ EXAMPLES ************************ -->

<div class="container mt-5 my-5 px-4 pb-5" id="examples">
  <h1 class="pt-5"><strong>Examples</strong></h1>
  <hr>

  <div class="row">
    <div class="col-12 col-md-6 mt-2">

      <p class="text-muted">Click on one of the following PDB-IDs to explore the corresponding entry <a class="link-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="These preprocessed data were collected from the Protein Data Bank (https://www.rcsb.org). pH values ​​used by COCaDA were obtained from the corresponding PDB file. Default cutoff values ​​were used to define contact types. For more details, see the documentation."><i class="bi bi-question-circle-fill"></i></a>:</p>
      <div class="row">
        <div class="col">
          <label class="badge bg-light text-dark">Protein single-chain</label>
          <a href="<?= base_url('/entry/1K0P') ?>" class="badge bg-primary azul">1K0P</a>
          <a href="<?= base_url('/entry/1TPM') ?>" class="badge bg-primary azul">1TPM</a>
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
    <div class="col-12 col-md-6 mt-2">
      <p class="text-muted">Or access an entry by typing the 4-characters PDB code <a class="link-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="E.g.: 2LZM. Using this option, COCaDA-web will use preprocessed data from its internal database. Default parameters will be used for this processing. See the documentation for details. To change the parameters used, use the 'Run COCaDA-web' option."><i class="bi bi-question-circle-fill"></i></a>:</p>
      <div class="row g-2">
        <div class="col-1">
          <input type="text" id="code1" name="code1" class="form-control validacao" size="1" maxlength="1">
        </div>
        <div class="col-1">
          <input type="text" id="code2" name="code2" class="form-control validacao" size="1" maxlength="1">
        </div>
        <div class="col-1">
          <input type="text" id="code3" name="code3" class="form-control validacao" size="1" maxlength="1">
        </div>
        <div class="col-1">
          <input type="text" id="code4" name="code4" class="form-control validacao" size="1" maxlength="1">
        </div>
        <div class="col-1">
          <button type="button" id="go" class="btn btn-dark azul" name="go" value="Go to entry"><i class="bi bi-play-fill"></i></button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const go = document.getElementById('go');

    go.addEventListener('click', () => {
      let c1 = document.getElementById('code1').value;
      let c2 = document.getElementById('code2').value;
      let c3 = document.getElementById('code3').value;
      let c4 = document.getElementById('code4').value;

      let code = c1+c2+c3+c4;

      code = code.toUpperCase();
      console.log(code)
      if (code) {
        if (code.length != 4) {
          window.location.href = '<?= base_url("/entry/404") ?>';
        }
        window.location.href = '<?= base_url() ?>entry/' + code;
      }
    });

    $(()=>{
      
      // pula para o proximo campo (keycode==8 => backspace)
      $("[name=code1]").on('keyup',(e)=>{ if(e.keyCode!=8 ){$("[name=code2]").focus() }});
      $("[name=code2]").on('keyup',()=>{ $("[name=code3]").focus() });
      $("[name=code3]").on('keyup',()=>{ $("[name=code4]").focus() });
      $("[name=code4]").on('keyup',()=>{ $("[name=go]").focus() });
      
      // ao apagar, volta para campo anterior
      $("[name=code4]").on('keyup', (e)=>{ if(e.keyCode==8){ $("[name=code3]").focus() }}); 
      $("[name=code3]").on('keyup', (e)=>{ if(e.keyCode==8){ $("[name=code2]").focus() }}); 
      $("[name=code2]").on('keyup', (e)=>{ if(e.keyCode==8){ $("[name=code1]").focus() }}); 

      // fallback para tooltips do Bootstrap
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })

    });
    
  </script>

  <?= $this->endSection() ?>