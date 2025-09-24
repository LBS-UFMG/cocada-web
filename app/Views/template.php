<!doctype html>
<html lang="pt-br">

<head>
    <title>COCaDA – The Protein Contacts Database</title>
    <?php $version = "25.924"; // 24-sep-2025 
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="<?= base_url('img/new_logo/favicon.png') ?>" type="image/x-icon">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?php echo base_url('DataTables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('css/estilo.css') ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
            
    <nav class="py-2 bg-body-tertiary menu link-light navbar-expand-md">
        <div class="px-4 container-fluid d-flex flex-wrap">

            <!-- Botão hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuCollapse"
                aria-controls="menuCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <h1 class="mb-0"><i class="bi bi-list text-white"></i></h1>
            </button>

            <div class="collapse navbar-collapse" id="menuCollapse">

                <ul class="nav me-auto">
                    <li class="nav-item"><a href="<?= base_url() ?>" class="nav-link link-body-emphasis px-2 active" aria-current="page">Home</a></li>
                    <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#about" class="nav-link link-body-emphasis px-2">About</a></li>
                    <li class="nav-item"><a href="<?= base_url('documentation') ?>" class="nav-link link-body-emphasis px-2">Documentation</a></li>
                    <li class="nav-item"><a href="<?= base_url('download') ?>" class="nav-link link-body-emphasis px-2">Download</a></li>
                    <li class="nav-item"><a href="<?= base_url('explore') ?>" class="nav-link link-body-emphasis px-2">Explore</a></li>
                    <li class="nav-item"><a href="<?= base_url('/#run') ?>" class="nav-link link-body-emphasis px-2">Try now</a></li>
                </ul>
                <ul class="nav">
                    <li class="nav-item"><a href="<?= base_url('/#cite') ?>" class="nav-link link-body-emphasis px-2">How to cite COCαDA-web</a></li>
                </ul>

            </div>
        </div>
    </nav>
    <header class="py-3 mb-4 border-bottom">
        <div class="px-4 container-fluid d-flex flex-wrap justify-content-center">
            <a href="<?= base_url() ?>" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                <img src="<?= base_url('/img/cocada.svg') ?>" width="250">
            </a>
            <form class="col-12 col-md-auto mb-3 mb-md-0" role="search" action="<?= base_url('/explore') ?>">
                <input type="search" class="form-control form-control-md mt-2" placeholder="Search..." aria-label="Search" id="urlInput" name="q"><!-- onkeydown="redirectToURL(event)" -->
            </form>
        </div>
    </header>

    <!-- PARTE DINÂMICA -->
    <main class="container-fluid">
        <?= $this->renderSection('conteudo') ?>
    </main>
    <!-- / FIM PARTE DINÂMICA -->

    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 ps-5">
                    <img src="<?= base_url('/img/cocada.svg') ?>" width="200px">
                    <p class="text-light small pt-3 col-9">COCαDA (COntact search pruning by Cα Distance Analysis) optimizes the calculation of atomic interactions in proteins, by using a set of fine-tuned Cα distances between every pair of aminoacid residues. The code includes a customized parser for both PDB and CIF files.</p>

                    <p style="font-size: 0.6em;color:#ccc">©<?= date('Y') ?> COCαDA-CLI v1.0 – web v<?= $version ?> | Laboratory of Bioinformatics and Systems, UFMG (Brazil) | <strong>GitHub</strong>: <a class="text-white" href="https://github.com/LBS-UFMG/cocada">CLI</a> | <a class="text-white" href="https://github.com/LBS-UFMG/cocada-web">Web</a>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row pt-5">
                        <div class="col"><a href="http://bioinfo.dcc.ufmg.br" target="_blank"><img src="<?= base_url('/img/lbs.svg') ?>" width="220px"></a></div>
                        <div class="col"><img src="<?= base_url('/img/dcc_w.svg') ?>" width="170px"></div>
                        <div class="col"><img src="<?= base_url('/img/ufmg_w.svg') ?>" width="200px"></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- MODAL: SOBRE -->
    <div class="modal fade" tabindex="-1" id="about" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <div class="text-center">
                        <img width="150" class="me-3" src="<?php echo base_url('/img/cocada.svg'); ?>">
                    </div>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body small">
                    <div class="row">
                        <p class="text-muted">
                            <strong>COCαDA (COntact search pruning by Cα Distance Analysis)</strong> optimizes the calculation of atomic interactions in proteins, by using a set of fine-tuned Cα distances between every pair of aminoacid residues. The code includes a customized parser for both PDB and CIF files, containing functionalities for handling large files, filtering out specific residues and interactions, and calculating geometric properties such as centroid and normal vectors for aromatic residues.

                        </p>
                    </div>
                    <div class="row text-secondary">
                        <div class="col-md-8">

                            <strong># Created by:</strong><br>
                            Rafael Lemos / Diego Mariano / Sabrina A. Silveira / Raquel C. de Melo-Minardi<br><br>

                            <strong># Backend/frontend:</strong><br>
                            Diego Mariano / Rafael Lemos
                        </div>
                    </div>
                    <hr>
                    <h4 class="text-muted mt-4">Please, cite COCαDA in your publication:</h4>
                    <label class="badge bg-success mt-2"><i class="bi bi-star-fill me-1"></i>Main article (2025)</label>
                    <p class="small text-muted border-start border-success mx-3 col-11 bg-light p-2">Lemos RP, Mariano D, Silveira SDA and de Melo-Minardi RC (2025) <strong>COCαDA - a fast and scalable algorithm for interatomic contact detection in proteins using Cα distance matrices</strong>. Front. Bioinform. 5:1630078. doi: <a href="https://doi.org/10.3389/fbinf.2025.1630078">10.3389/fbinf.2025.1630078</a></p>

                    <span><label class="badge bg-success mt-2">Conference paper (2024):</label></span>
                    <p class="small text-muted border-start border-success mx-3 col-11 bg-light p-2">LEMOS, Rafael P.; MARIANO, Diego; SILVEIRA, Sabrina A.; MELO-MINARDI, Raquel C. de. <strong>COCαDA - Large-Scale Protein Interatomic Contact Cutoff Optimization by Cα Distance Matrices</strong>. In: Proceedings of the XVII Brazilian Symposium on Bioinformatics (BSB), 17, p. 59-70, 2024. DOI: <a href="https://doi.org/10.5753/bsb.2024.245545">10.5753/bsb.2024.245545</a>
                    </p>
                </div>
                <div class="modal-footer">
                    <img height="50" class="me-3" src="<?php echo base_url('/img/dcc_b.svg'); ?>">
                    <img height="50" class="me-3" src="<?php echo base_url('/img/ufmg_b.svg'); ?>">

                    <button type="button" class="btn btn-success py-4 px-5" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal SOBRE -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script src="<?php echo base_url('DataTables/datatables.min.js'); ?>"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script src="<?php echo base_url('js/3dmol.js'); ?>"></script>

    <?= $this->renderSection('scripts') ?>

</body>

</html>