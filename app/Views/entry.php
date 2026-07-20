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
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                    <span class="btn btn-outline-dark" id="basic-addon1">
                        <span class="d-none d-md-inline"><b><i class="bi bi-funnel-fill"></i> Filter contacts: </b></span>
                        <span class="d-md-none"><i class="bi bi-funnel-fill"></i></span>
                    </span>
                    <button type="button" id="show_all" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Default">
                        <span class="d-none d-md-inline">All</span>
                        <span class="d-md-none">All</span>
                    </button>             
                    <button type="button" id="hb" class="btn btn-success border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hydrogen Bonds">HB</button>          
                    <button type="button" id="at" class="btn btn-info border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Attractive">AT</button>       
                    <button type="button" id="re" class="btn btn-danger border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Repulsive">RE</button>          
                    <button type="button" id="hy" class="btn btn-warning border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hydrophobic">HY</button>              
                    <button type="button" id="ar" class="btn btn-secondary border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Aromatic">AR</button>          
                    <button type="button" id="sb" class="btn btn-primary border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Salt Bridge">SB</button>           
                    <button type="button" id="ds" class="btn btn-light border border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Disulfide Bond">DS</button>
                    <button type="button" id="un" class="btn btn-white border border-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Uncertain contact (depends on pH; can be attractive, repulsive, or salt bridge)">UN</button>
                </div>

                <span class="small text-muted"><input type="checkbox" id="side_chain" class="btn btn-light border ms-1"> Only side chain contacts</span>
                
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
                <div id="pdb" style="min-height: 500px; height: 50vh; min-width:280px; width: 100%"></div>
                <p style="color:#ccc; text-align: right" class="small">
                    <a href="<?= base_url("/export/pdb-to-pymol/$id") ?>" class="me-2" target="_blank">Export to PyMOL</a> | <button class="btn btn-link btn-sm pt-0" onclick="reset()">Clear</button>
                </p>
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
            "paging": true
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
        $('#show_all').click(function() {
            table.columns(9).search(".*", true, false).draw();
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

    /* Select ID */
    function selectID(glviewer, residues, type, chain1, chain2, a1, a2) {

        // Labels e shapes ficam guardados no próprio viewer, para que cada
        // viewer (o principal e o do modal) gerencie os seus de forma independente
        (glviewer._contactLabels || []).forEach(function(l) {
            glviewer.removeLabel(l);
        });
        (glviewer._contactShapes || []).forEach(function(s) {
            glviewer.removeShape(s);
        });
        glviewer._contactLabels = [];
        glviewer._contactShapes = [];
        var contactLabels = glviewer._contactLabels;
        var contactShapes = glviewer._contactShapes;

        residues = residues.split("/");

        var res1 = residues[0].substr(1);
        var res2 = residues[1].substr(1);

        // Estrutura inteira semi-transparente para destacar os resíduos selecionados
        glviewer.setStyle({}, {
            line: {
                color: '#cccccc' // cinza claro: simula transparência (o estilo line não suporta opacity)
            },
            cartoon: {
                color: 'white',
                opacity: 0.3
            }
        }); /* Cartoon multi-color */
        glviewer.setStyle({
            resi: res1, chain: chain1
        }, {
            cartoon: {opacity:0.7},
            stick: {
                colorscheme: 'whiteCarbon'
            }
        });

        glviewer.setStyle({
            resi: res2, chain: chain2
        }, {
            cartoon: {opacity:0.7},
            stick: {
                colorscheme: 'whiteCarbon'
            }
        });

        if(type.includes('INTRA')){
            glviewer.zoomTo({
                resi: [res1, res2],
                chain: chain1
            });
        }
        else if(type.includes('INTER')){
            glviewer.zoomTo({
                resi: res1,
                chain: chain1
            });
        }

        // linha tracejada
        let atm1 = glviewer.selectedAtoms({ resi: res1, atom: a1, chain: chain1 }); // Resíduo 10, átomo O
        let atm2 = glviewer.selectedAtoms({ resi: res2, atom: a2, chain: chain2 }); // Resíduo 20, átomo N

        // Garantir que os átomos foram encontrados antes de desenhar a linha
        if (atm1.length > 0 && atm2.length > 0) {
            var atom1 = atm1[0]; // Primeiro átomo correspondente
            var atom2 = atm2[0]; // Primeiro átomo correspondente

            //console.log(atom2,'aqui')

            // Linha tracejada (grossa) entre os átomos em contato
            contactShapes.push(glviewer.addCylinder({
                dashed: true,
                start: { x: atom1.x, y: atom1.y, z: atom1.z },
                end: { x: atom2.x, y: atom2.y, z: atom2.z },
                radius: 0.12,   // grossura da linha tracejada
                fromCap: 1,
                toCap: 1,
                color: "orange"
            }));

            // Esferas sobre os átomos em contato, na cor do átomo
            contactShapes.push(glviewer.addSphere({
                center: { x: atom1.x, y: atom1.y, z: atom1.z },
                radius: 0.4,
                color: atomColor(atom1)
            }));
            contactShapes.push(glviewer.addSphere({
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

            contactLabels.push(glviewer.addLabel(
                three2one(atom1.resn) + atom1.resi + " (" + atom1.atom + ")",
                Object.assign({ position: { x: atom1.x, y: atom1.y, z: atom1.z } }, labelStyle)
            ));

            contactLabels.push(glviewer.addLabel(
                three2one(atom2.resn) + atom2.resi + " (" + atom2.atom + ")",
                Object.assign({ position: { x: atom2.x, y: atom2.y, z: atom2.z } }, labelStyle)
            ));

            // Label da distância de contato, no centro da linha
            var dx = atom1.x - atom2.x;
            var dy = atom1.y - atom2.y;
            var dz = atom1.z - atom2.z;
            var dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

            contactLabels.push(glviewer.addLabel(
                dist.toFixed(2) + " Å", // Å
                {
                    position: {
                        x: (atom1.x + atom2.x) / 2,
                        y: (atom1.y + atom2.y) / 2,
                        z: (atom1.z + atom2.z) / 2
                    },
                    fontSize: 11,
                    fontColor: "white",
                    backgroundColor: "orange",
                    backgroundOpacity: 0.85,
                    inFront: true
                }
            ));
        }
        // fim linha tracejada

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

        // Remove labels e shapes do contato selecionado nesse viewer
        (viewer._contactLabels || []).forEach(function(l) {
            viewer.removeLabel(l);
        });
        (viewer._contactShapes || []).forEach(function(s) {
            viewer.removeShape(s);
        });
        viewer._contactLabels = [];
        viewer._contactShapes = [];

        // Volta ao estilo inicial: estrutura inteira, sem transparência nem seleção
        viewer.setStyle({}, {
            line: {
                color: 'grey'
            },
            cartoon: {
                color: 'white'
            }
        });

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

            /* Type of visualization */
            glviewer.setStyle({}, {
                line: {
                    color: 'grey'
                },
                cartoon: {
                    color: 'white'
                }
            }); /* Cartoon multi-color */

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
        // aa1/aa2 são o código de 1 letra do resíduo; selectID espera "X<num>/Y<num>"
        const residues = `${p.aa1}${p.x}/${p.aa2}${p.y}`;
        const type = (p.c1 === p.c2) ? 'INTRA' : 'INTER';
        selectID(modalViewer, residues, type, p.c1, p.c2, p.at1, p.at2);
    }

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
            modalViewer.setStyle({}, {
                line: { color: 'grey' },
                cartoon: { color: 'white' }
            });
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