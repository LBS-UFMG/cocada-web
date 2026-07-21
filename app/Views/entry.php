<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<link rel="stylesheet" href="<?php echo base_url('/css/dt.css'); ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div id="loading">
    <div class="text-center">
        <img src="<?= base_url('/img/cocadito-loading.png') ?>" width="200px"><br>
        <div class="spinner-border spinner-border-sm" role="status"></div>
        <strong class="ms-2">Loading...</strong>
    </div>
</div>
<div style="background-color:#e4e4e4; min-height:180px; margin: -25px -10px 20px -10px;">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-9 col-12 pt-2">
                <h2 class="title_h2 pt-4">
                    <strong><?php echo $id; ?></strong>
                    <div class="dropdown d-inline ms-2" title="Export files">
                        <div class="dropdown d-inline">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Download
                            </button>
                            <ul class="dropdown-menu">
                                <li><b class="ms-3">Download</b></li>
                                <hr>
                                <li><a class="dropdown-item mt-2" href="<?php echo base_url(); ?>data/pdb/<?= substr($id, 0, 1) ?>/<?= $id ?>/<?= $id ?>_contacts.csv">Contacts</a></li>
                                <li><a class="dropdown-item" href="https://files.rcsb.org/download/<?php echo $id; ?>.cif">PDB file</a></li>
                                <hr>
                                <li><a class="dropdown-item" href="<?= base_url("/export/pdb-to-pymol/$id") ?>">Export to PyMOL</a></li>                                
                            </ul>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactMap">
                        Show contact map <i class="bi bi-image"></i>
                    </button>

                    <?php
                    // Último campo do *_info.csv indica se há biological assembly (yes/no)
                    $biological_assembly = isset($info) && is_array($info) ? trim(end($info)) : 'no';
                    if (strtolower($biological_assembly) === 'yes'): ?>
                        <a href="<?= base_url("/assembly/$id") ?>" class="btn btn-danger">
                            View biological assembly <i class="bi bi-diagram-3-fill"></i>
                        </a>
                    <?php endif; ?>
                </h2>
                <div class="col">
                    <p><strong>Description: </strong><?= $info[1] ?></p>
                </div>
                <div class="row">
                    <div class="col">
                        <p>
                            <strong>Residues: </strong><?= $info[2] ?>

                            <span class="mx-2"> | </span><strong>HB: </strong><span id="hbc"><?=$info[4]?></span>
                            <span class="mx-2"> | </span><strong>AT: </strong><span id="atc"><?=$info[6]?></span>
                            <span class="mx-2"> | </span><strong>RE: </strong><span id="rec"><?=$info[7]?></span>
                            <span class="mx-2"> | </span><strong>HY: </strong><span id="hyc"><?=$info[5]?></span>
                            <span class="mx-2"> | </span><strong>AS: </strong><span id="arc"><?=$info[10]?></span>
                            <span class="mx-2"> | </span><strong>SB: </strong><span id="sbc"><?=$info[8]?></span>
                            <span class="mx-2"> | </span><strong>DS: </strong><span id="dsc"><?=$info[9]?></span>
                            <span class="mx-2"> | </span><strong>uAT: </strong><span id="uat"><?=$info[11]?></span>
                            <span class="mx-2"> | </span><strong>uRE: </strong><span id="ure"><?=$info[12]?></span>
                            <span class="mx-2"> | </span><strong>uSB: </strong><span id="usb"><?=$info[13]?></span>
                            <span class="mx-2"> | </span><strong>pH: </strong><span id="ph"><?=$info[14]?></span>
                            <sup class="ms-2"><label class="badge bg-dark rounded" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="HB: Hydrogen Bonds | AT: Attractive  | RE: Repulsive | HY: Hydrophobic | AS: Aromatic Stacking | SB: Salt Bridge | DS: Disulfide Bond | u: uncertain">?</label></sup>
                        </p>
                    </div>
                </div>

            </div>

            <div class="col-md-3 col-xs-12" style="height: 180px; background-color: #00bc9e; color:#fff">
                <p style="text-align: center; font-size: 90px; padding-top:10px">
                    <strong id="mutations_found_title"><?php echo $total_results; ?></strong>
                </p>

                <p style="font-size: 12px; text-align:center; margin-top: -20px">
                    contacts found
                    <a href="#" data-toggle="modal" data-target="#help" style="color:#fff"><span class="glyphicon glyphicon-info-sign"></span></a>
                </p>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-8 col-12" ng-if="cttlok" id="col1">
            <center>
                <style>
                    /* Botões de filtro de contatos (estilo limpo com contagem) */
                    .contact-filters { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; align-items: center; }
                    .btn-filter {
                        border: 1px solid #adb5bd; background: #fff; color: #212529;
                        font-size: 0.75rem; padding: 4px 10px; border-radius: 4px;
                        font-weight: 600; line-height: 1.2; cursor: pointer; transition: background-color .15s;
                    }
                    .btn-filter:hover { background: #f1f3f5; }
                    .btn-filter.active { background: #212529; color: #fff; border-color: #212529; }
                    .badge-cnt {
                        background: rgba(0,0,0,.12); padding: 0 5px; border-radius: 3px;
                        margin-left: 5px; font-size: 0.7rem; color: inherit;
                    }
                    .btn-filter.active .badge-cnt { background: rgba(255,255,255,.25); color: #fff; }
                </style>

                <div class="contact-filters">
                    <span class="me-1 small text-muted d-none d-md-inline"><b><i class="bi bi-funnel-fill"></i> Filter:</b></span>
                    <button type="button" id="show_all" class="btn-filter btn-all active" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="All contacts">All <span class="badge-cnt"><?= number_format((int) $total_results) ?></span></button>
                    <button type="button" id="hb" class="btn-filter" style="border-bottom: 3px solid #198754" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hydrogen Bonds">HB <span class="badge-cnt"><?= number_format((int) $info[4]) ?></span></button>
                    <button type="button" id="at" class="btn-filter" style="border-bottom: 3px solid #0dcaf0" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Attractive">AT <span class="badge-cnt"><?= number_format((int) $info[6]) ?></span></button>
                    <button type="button" id="re" class="btn-filter" style="border-bottom: 3px solid #dc3545" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Repulsive">RE <span class="badge-cnt"><?= number_format((int) $info[7]) ?></span></button>
                    <button type="button" id="hy" class="btn-filter" style="border-bottom: 3px solid #ffc107" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hydrophobic">HY <span class="badge-cnt"><?= number_format((int) $info[5]) ?></span></button>
                    <button type="button" id="ar" class="btn-filter" style="border-bottom: 3px solid #6c757d" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Aromatic Stacking">AR <span class="badge-cnt"><?= number_format((int) $info[10]) ?></span></button>
                    <button type="button" id="sb" class="btn-filter" style="border-bottom: 3px solid #0d6efd" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Salt Bridge">SB <span class="badge-cnt"><?= number_format((int) $info[8]) ?></span></button>
                    <button type="button" id="ds" class="btn-filter" style="border-bottom: 3px solid #212529" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Disulfide Bond">DS <span class="badge-cnt"><?= number_format((int) $info[9]) ?></span></button>
                    <button type="button" id="un" class="btn-filter" style="border-bottom: 3px solid #ced4da" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uncertain contact (depends on pH; can be attractive, repulsive, or salt bridge)">UN <span class="badge-cnt"><?= number_format((int) $info[11] + (int) $info[12] + (int) $info[13]) ?></span></button>
                    <button type="button" id="intra" class="btn-filter" style="border-bottom: 3px solid #495057" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Intrachain contacts (same chain)">INTRA <span class="badge-cnt" id="cnt_intra">0</span></button>
                    <button type="button" id="inter" class="btn-filter" style="border-bottom: 3px solid #adb5bd" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Interchain contacts (different chains)">INTER <span class="badge-cnt" id="cnt_inter">0</span></button>
                </div>

                <div class="form-check form-switch d-inline-flex align-items-center align-middle ms-3">
                    <input class="form-check-input mt-0" type="checkbox" id="side_chain">
                    <label class="form-check-label small text-muted ms-2" for="side_chain">Only side chain contacts</label>
                </div>

            </center>

            <div class="table-responsive">
                <table class="display" id="mut">
                    <thead>
                        <tr>
                            <th>Contact</th>
                            <th>Chain1</th>
                            <th>R1</th>
                            <th>Atom1</th>
                            <th>Chain2</th>
                            <th>R2</th>
                            <th>Atom2</th>
                            <th>Distance</th>
                            <th>Local</th>
                            <th>Type</th>
                            <th>Show</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact) {  ?>
                            <?php
                            $m = explode(',', $contact);
                            $len_mut = count($m);
                            if (($len_mut < 5) or ($m[0] == 'Chain1')) {
                                continue;
                            }
                            ?>
                            <tr onclick="selectID(
                            glviewer,
                            this.children[0].innerHTML, // residues, 
                            this.children[8].innerHTML, // type, => inter ou intra
                            this.children[1].innerHTML,  // chain 1, 
                            this.children[4].innerHTML,  // chain 2, 
                            this.children[3].innerHTML,  // a1, 
                            this.children[6].innerHTML  // a2
                            )" id="<?php echo $m[2] . $m[1] . '/' . $m[6] . $m[5]; ?>">
                                <td><?php echo $m[2] . $m[1] . '/' . $m[6] . $m[5]; ?></td>
                                <td><?php echo $m[0]; // chain 1 
                                    ?></td>
                                <td><?php echo $m[2];
                                    echo $m[1]; // res 1 
                                    ?></td>
                                <td><?php echo $m[3]; // atom 1 
                                    ?></td>
                                <td><?php echo $m[4]; // chain 2 
                                    ?></td>
                                <td><?php echo $m[6];
                                    echo $m[5]; // res2 
                                    ?></td>
                                <td><?php echo $m[7]; // atom2 
                                    ?></td>
                                <td><?php echo $m[8]; // dist 
                                    ?></td>
                                <td>
                                    <?php // local = INTRA ou PPI
                                    if ($m[0] == $m[4]) {
                                        echo "<span class='badge text-bg-dark'>INTRA</hb>";
                                    } else {
                                        echo "<span class='badge text-bg-secondary'>INTER</hb>";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    //echo $m[9];  // type
                                    switch (trim($m[9])) {
                                        case "HB":
                                            echo "<span class='badge text-bg-success'>HB</hb>";
                                            break;
                                        case "HY":
                                            echo "<span class='badge text-bg-warning'>HY</hb>";
                                            break;
                                        case "AT":
                                            echo "<span class='badge text-bg-info'>AT</hb>";
                                            break;
                                        case "RE":
                                            echo "<span class='badge text-bg-danger'>RE</hb>";
                                            break;
                                        case "SB":
                                            echo "<span class='badge text-bg-primary'>SB</hb>";
                                            break;
                                        case "DS":
                                            echo "<span class='badge text-bg-dark text-white'>DS</hb>";
                                            break;
                                        default:
                                            echo "<span class='badge text-bg-light'>$m[9]</hb>";
                                            break;
                                    }

                                    ?>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);"><i class="bi bi-eye-fill"></i></a>
                                </td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="col-md-4" id="col2">

            <style>
                .affix {
                    top: 100px;
                    z-index: 9999 !important;
                }
            </style>

            <style>
                #pdb canvas {
                    position: relative !important;
                }
            </style>
            <div data-spy="affix" id="affix" data-offset-top="240" data-offset-bottom="250">
                <div class="d-flex align-items-center flex-wrap gap-2 mb-2 small">
                    <div class="form-check form-switch me-auto">
                        <input class="form-check-input" type="checkbox" id="show_lines">
                        <label class="form-check-label" for="show_lines">Show lines</label>
                    </div>
                    <a href="<?= base_url("/export/pdb-to-pymol/$id") ?>" class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> Export to PyMOL
                    </a>
                    <button class="btn btn-sm btn-outline-secondary" onclick="reset()">
                        <i class="bi bi-arrow-counterclockwise"></i> Clear
                    </button>
                </div>
                <div id="pdb" style="min-height: 500px; height: 50vh; min-width:280px; width: 100%"></div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="contactMap" tabindex="-1" aria-labelledby="contactMap" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3 text-center w-100" id="contactMapTitle"><strong>Contact map for <?= $id ?></strong></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            <div id="controls">
                    <div class="row px-4">
                        <div class="col">
                            <label for="chainX">X-axis Chain:</label>
                            <select id="chainX" class="form-select" onchange="updateChart()"></select>
                        </div>
                        <div class="col">
                            <label for="chainY">Y-axis Chain:</label>
                            <select id="chainY" class="form-select" onchange="updateChart()"></select>
                        </div>
                        <!-- <div class="col">
                                <button class="btn btn-primary w-100 mt-4" onclick="updateChart()">Update chart</button>
                            </div> -->
                        <div class="col">
                            <button id="saveButton" class="btn btn-success w-100 mt-4" onclick="saveChart()">Save figure</button>
                        </div>
                    </div>
                </div>

                <style>
                    #pdb_modal canvas {
                        position: relative !important;
                    }
                </style>
                <div class="row mt-3">

                    <!-- Mapa de contatos (Chart.js) -->
                    <div class="col-lg-6 col-12">
                        <div style="position: relative; height: calc(100vh - 220px);">
                            <!-- Botão Back sobreposto, ao lado da legenda (topo do gráfico) -->
                            <button id="backButton" class="btn btn-sm btn-outline-secondary"
                                onclick="resetChartZoom()"
                                style="position: absolute; top: 0; right: 0; z-index: 5;">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset Zoom
                            </button>
                            <canvas id="scatterChart"></canvas>
                        </div>
                    </div>

                    <!-- Visualização 3D do par selecionado -->
                    <div class="col-lg-6 col-12">
                        <p class="text-muted small mb-1">Click a point on the map to display the contact pair here.</p>
                        <div id="pdb_modal" style="height: calc(100vh - 260px); min-height: 400px; width: 100%; position: relative;"></div>
                        <p style="color:#ccc; text-align: right" class="small">
                            <button class="btn btn-link btn-sm pt-0" onclick="resetViewer(modalViewer)">Clear</button>
                        </p>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-white">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Return to Top -->
<a href="#" title="Return to top" style="position:fixed; right:10px; bottom:10px; color:#cccccc77"><span class="glyphicon glyphicon-chevron-up small" aria-hidden="true">Return to top</span></a>

<script> 
    // loading
    $(() => setTimeout(() => $('#loading').fadeOut(), 1000));

    $(document).ready(function() {
        var table = $('#mut').DataTable({
            "paging": true,
            // Ordenação padrão: Chain1 (col. 1, alfabética) e depois R1 (col. 2, numérica), ascendentes
            "order": [[1, "asc"], [2, "asc"]],
            // R1 (col. 2) e R2 (col. 5) guardam "X<número>" (ex.: A128).
            // Ordena pelo número, ignorando o código de 1 letra do aminoácido.
            "columnDefs": [
                {
                    "targets": [2, 5],
                    "render": function(data, type) {
                        if (type === 'sort' || type === 'type') {
                            var m = String(data).match(/-?\d+/);
                            return m ? parseInt(m[0], 10) : 0;
                        }
                        return data;
                    }
                }
            ]
        });

        // Contagens INTRA/INTER (a partir da coluna "Local", índice 8)
        (function() {
            var nIntra = 0, nInter = 0;
            table.column(8).data().each(function(v) {
                var s = String(v);
                if (s.indexOf('INTRA') > -1) { nIntra++; }
                else if (s.indexOf('INTER') > -1) { nInter++; }
            });
            $('#cnt_intra').text(nIntra.toLocaleString());
            $('#cnt_inter').text(nInter.toLocaleString());
        })();

        // Destaca (estado ativo) o botão de filtro clicado
        $('.btn-filter').on('click', function() {
            $('.btn-filter').removeClass('active');
            $(this).addClass('active');
        });

        $('#side_chain').click(function() {
            if ($("#side_chain").prop("checked")) {
                table
                    .columns(3).search("CB|CG|CG1|CG2|CD|CD1|CD2|CE|CE1|CE2|CE3|CZ|CZ2|CZ3|CH2|ND1|ND2|NE|NE1|NE2|NZ|OD1|OD2|OE1|OE2|OG|OG1|OH|SD|SG", true, false)
                    .columns(6).search("CB|CG|CG1|CG2|CD|CD1|CD2|CE|CE1|CE2|CE3|CZ|CZ2|CZ3|CH2|ND1|ND2|NE|NE1|NE2|NZ|OD1|OD2|OE1|OE2|OG|OG1|OH|SD|SG", true, false)
                    .draw();
            } else {
                table.columns(3).search(".*", true, false)
                    .columns(6).search(".*", true, false).draw();
            }
        });

        $('#at').click(function() {
            table.columns(9).search("AT", true, false).draw();
        });
        $('#hb').click(function() {
            table.columns(9).search("HB", true, false).draw();
        });
        $('#re').click(function() {
            table.columns(9).search("RE", true, false).draw();
        });
        $('#ar').click(function() {
            table.columns(9).search("AS|SPA|SPE|SOT", true, false).draw();
        });
        $('#hy').click(function() {
            table.columns(9).search("HY", true, false).draw();
        });
        $('#sb').click(function() {
            table.columns(9).search("SB", true, false).draw();
        });
        $('#ds').click(function() {
            table.columns(9).search("DS", true, false).draw();
        });
        $('#un').click(function() {
            table.columns(9).search("u", true, false).draw();
        });
        // INTRA/INTER filtram a coluna "Local" (índice 8)
        $('#intra').click(function() {
            table.columns(8).search("INTRA", true, false).draw();
        });
        $('#inter').click(function() {
            table.columns(8).search("INTER", true, false).draw();
        });
        $('#show_all').click(function() {
            // Limpa tanto o filtro de tipo (col. 9) quanto o de Local (col. 8)
            table.columns(9).search(".*", true, false)
                .columns(8).search(".*", true, false).draw();
        });


    });


    $('nav').css('position', 'relative');

    function highlight(pos) {
        $(pos).css("background-color", "#f2dede");
    }

    // 3DMOL **********************************************************************
    /* Converte o nome do resíduo de 3 letras (ALA) para 1 letra (A) */
    function three2one(resn) {
        var map = {
            ALA: 'A', ARG: 'R', ASN: 'N', ASP: 'D', CYS: 'C',
            GLN: 'Q', GLU: 'E', GLY: 'G', HIS: 'H', ILE: 'I',
            LEU: 'L', LYS: 'K', MET: 'M', PHE: 'F', PRO: 'P',
            SER: 'S', THR: 'T', TRP: 'W', TYR: 'Y', VAL: 'V'
        };
        var code = map[String(resn).toUpperCase().trim()];
        return code ? code : resn; // desconhecido: mantém o nome original
    }

    /* Cor do átomo conforme o elemento (esquema rasmol usado no viewer) */
    function atomColor(atom) {
        var colors = ($3Dmol.elementColors && $3Dmol.elementColors.rasmol) ||
            $3Dmol.rasmolElementColors || {};
        var c = colors[atom.elem];
        return (c === undefined) ? 0xcccccc : c; // desconhecido: cinza claro
    }

    // Estado do checkbox "Show lines": controla se a representação em LINHAS da
    // estrutura (o estilo `line` do 3Dmol) é exibida. Oculta por padrão, pois
    // costuma poluir a visualização (cartoon + sticks já bastam).
    var showLines = false;

    // Parte `line` do estilo, conforme o toggle. Quando oculta, usa hidden:true.
    function lineStylePart(color) {
        return showLines ? { color: color } : { hidden: true };
    }

    // Aplica o estilo da estrutura inteira (estado inicial / após Clear):
    // cartoon branco e, opcionalmente, linhas. Guarda um callback para reaplicar
    // o mesmo estilo quando o toggle "Show lines" mudar.
    function styleWhole(viewer) {
        viewer.setStyle({}, {
            line: lineStylePart('grey'),
            cartoon: { color: 'white' }
        });
        viewer._reapplyStyle = function() { styleWhole(viewer); };
    }

    // Aplica o estilo de destaque de um par: estrutura semi-transparente (+ linhas
    // opcionais) e sticks nos dois resíduos. Também guarda o callback de reaplicação.
    function styleHighlight(viewer, res1, chain1, res2, chain2) {
        viewer.setStyle({}, {
            line: lineStylePart('#cccccc'),
            cartoon: { color: 'white', opacity: 0.3 }
        });
        viewer.setStyle({ resi: res1, chain: chain1 }, {
            cartoon: { opacity: 0.7 },
            stick: { colorscheme: 'whiteCarbon' }
        });
        viewer.setStyle({ resi: res2, chain: chain2 }, {
            cartoon: { opacity: 0.7 },
            stick: { colorscheme: 'whiteCarbon' }
        });
        viewer._reapplyStyle = function() { styleHighlight(viewer, res1, chain1, res2, chain2); };
    }

    // Toggle "Show lines": reaplica o estilo atual de cada viewer respeitando o
    // novo valor de showLines, preservando o destaque/seleção corrente.
    function toggleLines(show) {
        showLines = show;
        [typeof glviewer !== 'undefined' ? glviewer : null, modalViewer].forEach(function(v) {
            if (v && v._reapplyStyle) {
                v._reapplyStyle();
                v.render();
            }
        });
    }

    // Destaca um par de resíduos: estrutura semi-transparente, sticks nos
    // dois resíduos e zoom. Limpa labels/shapes anteriores do viewer.
    function highlightPair(viewer, res1, chain1, res2, chain2, type) {

        // Labels e shapes ficam guardados no próprio viewer, para que cada
        // viewer (o principal e o do modal) gerencie os seus de forma independente
        (viewer._contactLabels || []).forEach(function(l) {
            viewer.removeLabel(l);
        });
        (viewer._contactShapes || []).forEach(function(s) {
            viewer.removeShape(s);
        });
        viewer._contactLabels = [];
        viewer._contactShapes = [];

        // Estilo de destaque (cartoon 0.3 + sticks nos resíduos + linhas opcionais)
        styleHighlight(viewer, res1, chain1, res2, chain2);

        if(type.includes('INTRA')){
            viewer.zoomTo({
                resi: [res1, res2],
                chain: chain1
            });
        }
        else if(type.includes('INTER')){
            viewer.zoomTo({
                resi: res1,
                chain: chain1
            });
        }
    }

    // Desenha UMA linha de contato (átomo a1 -> átomo a2): linha tracejada,
    // esferas nos átomos, labels dos resíduos e a distância no centro.
    // `color` define a cor da linha e do label de distância (padrão laranja).
    function drawContact(viewer, res1, chain1, a1, res2, chain2, a2, color) {

        color = color || "orange";
        var contactLabels = viewer._contactLabels || (viewer._contactLabels = []);
        var contactShapes = viewer._contactShapes || (viewer._contactShapes = []);

        let atm1 = viewer.selectedAtoms({ resi: res1, atom: a1, chain: chain1 });
        let atm2 = viewer.selectedAtoms({ resi: res2, atom: a2, chain: chain2 });

        // Garantir que os átomos foram encontrados antes de desenhar a linha
        if (atm1.length > 0 && atm2.length > 0) {
            var atom1 = atm1[0]; // Primeiro átomo correspondente
            var atom2 = atm2[0]; // Primeiro átomo correspondente

            // Linha tracejada (grossa) entre os átomos em contato
            contactShapes.push(viewer.addCylinder({
                dashed: true,
                start: { x: atom1.x, y: atom1.y, z: atom1.z },
                end: { x: atom2.x, y: atom2.y, z: atom2.z },
                radius: 0.12,   // grossura da linha tracejada
                fromCap: 1,
                toCap: 1,
                color: color
            }));

            // Esferas sobre os átomos em contato, na cor do átomo
            contactShapes.push(viewer.addSphere({
                center: { x: atom1.x, y: atom1.y, z: atom1.z },
                radius: 0.4,
                color: atomColor(atom1)
            }));
            contactShapes.push(viewer.addSphere({
                center: { x: atom2.x, y: atom2.y, z: atom2.z },
                radius: 0.4,
                color: atomColor(atom2)
            }));

            // Labels dos resíduos em contato (ex.: A128 (OH) = alanina 128, átomo OH)
            var labelStyle = {
                fontSize: 12,
                fontColor: "white",
                backgroundColor: "black",
                backgroundOpacity: 0.8,
                inFront: true,
                borderThickness: 0.5,
                borderColor: "white"
            };

            contactLabels.push(viewer.addLabel(
                three2one(atom1.resn) + atom1.resi + " (" + atom1.atom + ")",
                Object.assign({ position: { x: atom1.x, y: atom1.y, z: atom1.z } }, labelStyle)
            ));

            contactLabels.push(viewer.addLabel(
                three2one(atom2.resn) + atom2.resi + " (" + atom2.atom + ")",
                Object.assign({ position: { x: atom2.x, y: atom2.y, z: atom2.z } }, labelStyle)
            ));

            // Label da distância de contato, no centro da linha
            var dx = atom1.x - atom2.x;
            var dy = atom1.y - atom2.y;
            var dz = atom1.z - atom2.z;
            var dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

            contactLabels.push(viewer.addLabel(
                dist.toFixed(2) + " Å",
                {
                    position: {
                        x: (atom1.x + atom2.x) / 2,
                        y: (atom1.y + atom2.y) / 2,
                        z: (atom1.z + atom2.z) / 2
                    },
                    fontSize: 11,
                    fontColor: "white",
                    backgroundColor: color,
                    backgroundOpacity: 0.85,
                    inFront: true
                }
            ));
        }
    }

    /* Select ID (usado pela tabela): destaca o par e desenha um único contato */
    function selectID(glviewer, residues, type, chain1, chain2, a1, a2) {

        residues = residues.split("/");

        var res1 = residues[0].substr(1);
        var res2 = residues[1].substr(1);

        highlightPair(glviewer, res1, chain1, res2, chain2, type);
        drawContact(glviewer, res1, chain1, a1, res2, chain2, a2);

        glviewer.render();
    }

    function selectPDB(id) {

        var ids = id.split("_");
        var mut = ids[1].replace("/", "_");

        try {
            var pos = mut.split("_");
            var pos1 = pos[0].substr(1, pos[0].length - 2);
            var pos2 = pos[1].substr(1, pos[1].length - 2);
            var pos1a = Number(pos1) - 1;
            var pos1d = Number(pos1) + 1;
            var pos2a = Number(pos2) - 1;
            var pos2d = Number(pos2) + 1;
            pos1a = pos1a.toString();
            pos1d = pos1d.toString();
            pos2a = pos2a.toString();
            pos2d = pos2d.toString();
        } catch (err) {
            var erro = 1;
        }


        var atomcallback = function(atom, viewer) {
            if (atom.clickLabel === undefined ||
                !atom.clickLabel instanceof $3Dmol.Label) {
                atom.clickLabel = viewer.addLabel(atom.resn + " " + atom.resi + " (" + atom.elem + ")", {
                    fontSize: 10,
                    position: {
                        x: atom.x,
                        y: atom.y,
                        z: atom.z
                    },
                    backgroundColor: "black"
                });
                atom.clicked = true;
            }

            //toggle label style
            else {

                if (atom.clicked) {
                    var newstyle = atom.clickLabel.getStyle();
                    newstyle.backgroundColor = 0x66ccff;

                    viewer.setLabelStyle(atom.clickLabel, newstyle);
                    atom.clicked = !atom.clicked;
                } else {
                    viewer.removeLabel(atom.clickLabel);
                    delete atom.clickLabel;
                    atom.clicked = false;
                }
            }
        };
    }

    // Reseta um viewer específico ao estado inicial (estrutura inteira, sem seleção)
    function resetViewer(viewer) {
        if (!viewer) {
            return;
        }

        // Remove shapes do contato selecionado nesse viewer
        (viewer._contactShapes || []).forEach(function(s) {
            viewer.removeShape(s);
        });
        viewer._contactLabels = [];
        viewer._contactShapes = [];

        // Remove TODOS os labels: tanto os do contato quanto os rótulos criados
        // ao clicar em átomos (atomcallback guarda em atom.clickLabel)
        viewer.removeAllLabels();

        // Zera o estado de clique dos átomos, para que um novo clique volte a
        // criar o rótulo corretamente (senão o átomo continuaria "clicado")
        viewer.selectedAtoms({}).forEach(function(atom) {
            delete atom.clickLabel;
            atom.clicked = false;
        });

        // Volta ao estilo inicial: estrutura inteira (linhas conforme o toggle)
        styleWhole(viewer);

        viewer.zoomTo();
        viewer.render();
    }

    // Botão Clear do viewer principal
    function reset(){
        console.log("Reiniciando visualização")
        if (typeof glviewer !== 'undefined' && glviewer) {
            resetViewer(glviewer);
        }
    }

    $(document).ready(function() {

        //var title_pdb = $(".title_h2").text();
        //title_pdb = title_pdb.split(": ")

        var txt = "https://files.rcsb.org/download/<?php echo $id; ?>.pdb";
        //var txt = "<?php echo base_url(); ?>/data/<?php echo $id; ?>/data.pdb";

        $.get(txt, function(d) {

            moldata = data = d;

            /* Creating visualization */
            glviewer = $3Dmol.createViewer("pdb", {
                defaultcolors: $3Dmol.rasmolElementColors
            });

            /* Color background */
            glviewer.setBackgroundColor(0xffffff);

            receptorModel = m = glviewer.addModel(data, "pqr");

            /* Type of visualization: cartoon + linhas (ocultas por padrão) */
            styleWhole(glviewer);

            /*glviewer.addSurface($3Dmol.SurfaceType, {opacity:0.3});  Surface */

            /* Name of the atoms */
            atoms = m.selectedAtoms({});
            for (var i in atoms) {
                var atom = atoms[i];
                atom.clickable = true;
                atom.callback = atomcallback;
            }

            glviewer.mapAtomProperties($3Dmol.applyPartialCharges);
            glviewer.zoomTo();
            glviewer.render();

        });

        var atomcallback = function(atom, viewer) {
            if (atom.clickLabel === undefined ||
                !atom.clickLabel instanceof $3Dmol.Label) {
                atom.clickLabel = viewer.addLabel(atom.resn + " " + atom.resi + " (" + atom.elem + ")", {
                    fontSize: 10,
                    position: {
                        x: atom.x,
                        y: atom.y,
                        z: atom.z
                    },
                    backgroundColor: "black"
                });
                atom.clicked = true;
            }

            //toggle label style
            else {

                if (atom.clicked) {
                    var newstyle = atom.clickLabel.getStyle();
                    newstyle.backgroundColor = 0x66ccff;

                    viewer.setLabelStyle(atom.clickLabel, newstyle);
                    atom.clicked = !atom.clicked;
                } else {
                    viewer.removeLabel(atom.clickLabel);
                    delete atom.clickLabel;
                    atom.clicked = false;
                }
            }
        };
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Plugin oficial de zoom/pan do Chart.js (Hammer.js habilita gestos de toque) -->
<script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>

<script>
    // tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


    // MAPA DE CONTATOS
    let allChains = new Set();
    let allDataPoints = [];
    let datasetsMap = {}; // pontos agrupados por categoria (tipo de contato)
    let scatterChart;
    let colorMap = {};
    let modalViewer = null; // viewer 3Dmol dentro do modal
    const cat10Colors = [
        '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
        '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'
    ];

    function populateChainSelectors() {
        const chainX = document.getElementById('chainX');
        const chainY = document.getElementById('chainY');
        chainX.innerHTML = "";
        chainY.innerHTML = "";
        allChains.forEach(chain => {
            const optionX = document.createElement("option");
            optionX.value = optionX.textContent = chain;
            const optionY = document.createElement("option");
            optionY.value = optionY.textContent = chain;
            chainX.appendChild(optionX);
            chainY.appendChild(optionY);
        });
        chainX.value = 'A';
        chainY.value = 'A';
    }

    function updateChart() {
        const selectedX = document.getElementById('chainX').value;
        const selectedY = document.getElementById('chainY').value;

        // Cada dataset corresponde a uma categoria; refiltra pela cadeia escolhida
        scatterChart.data.datasets.forEach(ds => {
            ds.data = (datasetsMap[ds.label] || []).filter(p => p.c1 === selectedX && p.c2 === selectedY);
        });
        scatterChart.options.scales.x.title.text = `Chain ${selectedX}`;
        scatterChart.options.scales.y.title.text = `Chain ${selectedY}`;
        scatterChart.update();
    }

    function saveChart() {
        const canvas = document.getElementById('scatterChart');
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = 'contacts_<?= $id ?>.png';
        link.click();
    }

    // Volta o mapa de contatos ao enquadramento original (desfaz o zoom)
    function resetChartZoom() {
        if (scatterChart) {
            scatterChart.resetZoom();
        }
    }

    // Converte uma cor hexadecimal (#rrggbb) para rgba com a opacidade indicada
    function hexToRgba(hex, alpha) {
        const h = hex.replace('#', '');
        const r = parseInt(h.substring(0, 2), 16);
        const g = parseInt(h.substring(2, 4), 16);
        const b = parseInt(h.substring(4, 6), 16);
        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    // Exibe, no viewer 3D do modal, o par de contatos do ponto clicado no mapa.
    // Reutiliza selectID (mesmos padrões visuais do viewer principal).
    function showContactInModal(p) {
        if (!modalViewer) {
            return;
        }

        const res1 = String(p.x);
        const res2 = String(p.y);
        const type = (p.c1 === p.c2) ? 'INTRA' : 'INTER';

        // Destaca o par de resíduos uma única vez (limpa contatos anteriores)
        highlightPair(modalViewer, res1, p.c1, res2, p.c2, type);

        // Um ponto do mapa pode sobrepor vários contatos (átomos/tipos diferentes)
        // entre o mesmo par de resíduos: desenha uma linha para cada um deles,
        // colorida conforme o tipo de contato (mesmas cores da legenda do mapa).
        const pairContacts = allDataPoints.filter(function(q) {
            return q.c1 === p.c1 && q.c2 === p.c2 && q.x === p.x && q.y === p.y;
        });

        pairContacts.forEach(function(q) {
            drawContact(
                modalViewer,
                String(q.x), q.c1, q.at1,
                String(q.y), q.c2, q.at2,
                colorMap[q.category] || 'orange'
            );
        });

        modalViewer.render();
    }

    // Checkbox "Show lines": mostra/oculta as linhas de contato nos dois viewers
    $('#show_lines').on('change', function() {
        toggleLines(this.checked);
    });

    // Cria o viewer 3D dentro do modal na primeira vez que ele é aberto.
    // (Precisa ser criado com o modal visível para o canvas ter dimensões corretas.)
    document.getElementById('contactMap').addEventListener('shown.bs.modal', function() {
        if (!modalViewer) {
            modalViewer = $3Dmol.createViewer('pdb_modal', {
                defaultcolors: $3Dmol.rasmolElementColors
            });
            modalViewer.setBackgroundColor(0xffffff);
        }

        // Carrega o modelo assim que o PDB estiver disponível (lazy: pode ainda
        // estar baixando na primeira abertura do modal)
        if (!modalViewer._modelLoaded && typeof moldata !== 'undefined' && moldata) {
            modalViewer.addModel(moldata, 'pqr');
            styleWhole(modalViewer);
            modalViewer.zoomTo();
            modalViewer.render();
            modalViewer._modelLoaded = true;
        }

        // Ajusta o tamanho do canvas do 3Dmol e do gráfico agora que estão visíveis
        modalViewer.resize();
        modalViewer.render();
        if (scatterChart) {
            scatterChart.resize();
        }
    });

    fetch('<?php echo base_url(); ?>data/pdb/<?= substr($id, 0, 1) ?>/<?= $id ?>/<?= $id ?>_contacts.csv')
        .then(response => response.text())
        .then(text => {
            const lines = text.split('\n').map(line => line.trim()).filter(line => line);
            lines.shift(); // Ignorar a primeira linha
            let colorIndex = 0;

            lines.forEach(line => {
                const values = line.split(',');
                if (values.length >= 10) {
                    const c1 = values[0];
                    const x = parseFloat(values[1]);
                    const aa1 = values[2];
                    const at1 = values[3];
                    const c2 = values[4];
                    const y = parseFloat(values[5]);
                    const aa2 = values[6];
                    const at2 = values[7];
                    const category = values[9].trim();
                    const label = `${category} | ${c1}:${aa1}${x} (${at1}) - ${c2}:${aa2}${y} (${at2})`;

                    allChains.add(c1);
                    allChains.add(c2);

                    if (!colorMap[category]) {
                        colorMap[category] = cat10Colors[colorIndex % cat10Colors.length];
                        colorIndex++;
                    }

                    const point = {
                        x,
                        y,
                        c1,
                        c2,
                        aa1,
                        aa2,
                        at1,
                        at2,
                        category,
                        backgroundColor: colorMap[category],
                        label
                    };

                    allDataPoints.push(point);

                    // Agrupa por categoria para gerar um dataset por tipo de contato
                    if (!datasetsMap[category]) {
                        datasetsMap[category] = [];
                    }
                    datasetsMap[category].push(point);
                }
            });

            populateChainSelectors();

            // Um dataset por categoria: assim a legenda nativa do Chart.js
            // permite ocultar/mostrar os pontos de cada tipo ao clicar nela
            const datasets = Object.keys(datasetsMap).map(category => ({
                label: category,
                data: datasetsMap[category].filter(p => p.c1 === 'A' && p.c2 === 'A'),
                backgroundColor: colorMap[category],
                borderWidth: 0,
                pointRadius: 5,
                pointHoverRadius: 7,
            }));

            const ctx = document.getElementById('scatterChart').getContext('2d');
            scatterChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    // Clique em um ponto: exibe o par de contatos no viewer 3D do modal
                    onClick: function(event, elements) {
                        if (elements.length > 0) {
                            const el = elements[0];
                            const point = scatterChart.data.datasets[el.datasetIndex].data[el.index];
                            showContactInModal(point);
                        }
                    },
                    onHover: function(event, elements) {
                        if (event.native && event.native.target) {
                            event.native.target.style.cursor = elements.length ? 'pointer' : 'default';
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw.label;
                                }
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            // onClick padrão do Chart.js: oculta os pontos da categoria
                            // no gráfico e risca o texto correspondente na legenda
                            labels: {
                                usePointStyle: true,
                                // Quando a categoria está oculta, deixa apenas a
                                // bolinha da legenda semi-transparente
                                generateLabels: function(chart) {
                                    const labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                                    labels.forEach(function(label) {
                                        if (label.hidden) {
                                            const c = hexToRgba(colorMap[label.text], 0.3);
                                            label.fillStyle = c;
                                            label.strokeStyle = c;
                                        }
                                    });
                                    return labels;
                                }
                            }
                        },
                        // Zoom por seleção de região (arrastar), roda do mouse e pinça
                        zoom: {
                            zoom: {
                                drag: {
                                    enabled: true,
                                    backgroundColor: 'rgba(0, 123, 255, 0.15)',
                                    borderColor: 'rgba(0, 123, 255, 0.6)',
                                    borderWidth: 1
                                },
                                wheel: {
                                    enabled: true
                                },
                                pinch: {
                                    enabled: true
                                },
                                mode: 'xy'
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Chain A'
                            },
                            beginAtZero: false,
                            min: 1,
                            ticks: {
                                precision: 0 // apenas números inteiros (nº de resíduo)
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Chain A'
                            },
                            beginAtZero: false,
                            min: 1,
                            ticks: {
                                precision: 0 // apenas números inteiros (nº de resíduo)
                            }
                        }
                    }
                }
            });


        })
        .catch(error => console.error('Erro ao carregar o arquivo CSV:', error));
</script>
<?= $this->endSection() ?>