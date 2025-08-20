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
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-9 col-12">
                <br><br>
                <h2 class="title_h2">

                    <div class="btn-toolbar" role="toolbar">

                        <strong><?php echo $id; ?></strong>

                        <div class="dropdown" title="Export files">

                            <div class="dropdown">
                                <button class="btn ms-2 btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Download
                                </button>
                                <ul class="dropdown-menu">
                                    <li><b class="ms-3">Download files<br></b></li>
                                    <hr>
                                    <li><a class="dropdown-item mt-2" href="<?= base_url() ?>data/projects/<?= $id ?>/contacts.csv">Contacts</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url() ?>data/projects/<?= $id ?>/data.<?= $extensao ?>">PDB/CIF file</a></li>
                                    <hr>
                                    <li><a class="dropdown-item" href="<?= base_url("/export/pymol/$id") ?>">Export to PyMOL</a></li>
                                </ul>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#contactMap">
                            Show contact map <i class="bi bi-image"></i>
                        </button>

                        <button onclick="copyLink()" class="btn ms-2 btn-outline-secondary" title="Copy URL project"><i class="bi bi-copy"></i></button>
                    </div>
                </h2>
                <p>
                    <strong>Residues: </strong><?= $info[2] ?>

                    <span class="mx-2"> | </span><strong>HB: </strong><span id="hbc"><?= $info[4] ?></span>
                    <span class="mx-2"> | </span><strong>AT: </strong><span id="atc"><?= $info[6] ?></span>
                    <span class="mx-2"> | </span><strong>RE: </strong><span id="rec"><?= $info[7] ?></span>
                    <span class="mx-2"> | </span><strong>HY: </strong><span id="hyc"><?= $info[5] ?></span>
                    <span class="mx-2"> | </span><strong>AS: </strong><span id="arc"><?= $info[10] ?></span>
                    <span class="mx-2"> | </span><strong>SB: </strong><span id="sbc"><?= $info[8] ?></span>
                    <span class="mx-2"> | </span><strong>DS: </strong><span id="dsc"><?= $info[9] ?></span>
                    <span class="mx-2"> | </span><strong>uAT: </strong><span id="uat"><?= $info[11] ?></span>
                    <span class="mx-2"> | </span><strong>uRE: </strong><span id="ure"><?= $info[12] ?></span>
                    <span class="mx-2"> | </span><strong>uSB: </strong><span id="usb"><?= $info[13] ?></span>
                    <span class="mx-2"> | </span><strong>pH: </strong><span id="ph"><?= $info[14] ?></span>
                    <sup class="ms-2"><label class="badge bg-dark rounded" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="HB: Hydrogen Bonds | AT: Attractive  | RE: Repulsive | HY: Hydrophobic | AS: Aromatic Stacking | SB: Salt Bridge | DS: Disulfide Bond | u: uncertain">?</label></sup>

                </p>

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


<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-12" ng-if="cttlok">

            <center>
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                    <span class="btn btn-outline-dark" id="basic-addon1">
                        <span class="d-none d-md-inline"><b><i class="bi bi-funnel-fill"></i> Filter results: </b></span>
                        <span class="d-md-none"><i class="bi bi-funnel-fill"></i></span>
                    </span>
                    <button type="button" id="show_all" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Default">
                        <span class="d-none d-md-inline">Show all contacts</span>
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
                        <?php foreach ($contacts as $contact) { ?>
                            <?php $m = explode(',', $contact);
                            $len_mut = count($m);
                            if (($len_mut < 5) or ($m[0] == 'Chain1')) {
                                continue;
                            } ?>
                            <tr onclick="selectID(glviewer,this.children[0].innerHTML,1,this.children[1].innerHTML, this.children[3].innerHTML, this.children[6].innerHTML)" id="<?php echo $m[2] . $m[1] . '/' . $m[6] . $m[5]; ?>">
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
                                        echo "<span class='badge text-bg-dark'>INTRA</span>";
                                    } else {
                                        echo "<span class='badge text-bg-secondary'>INTER</span>";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    //echo $m[9];  // type
                                    switch (trim($m[9])) {
                                        case "HB":
                                            echo "<span class='badge text-bg-success'>HB</span>";
                                            break;
                                        case "HY":
                                            echo "<span class='badge text-bg-warning'>HY</span>";
                                            break;
                                        case "AT":
                                            echo "<span class='badge text-bg-info'>AT</span>";
                                            break;
                                        case "RE":
                                            echo "<span class='badge text-bg-danger'>RE</span>";
                                            break;
                                        case "SB":
                                            echo "<span class='badge text-bg-primary'>SB</span>";
                                            break;
                                        case "DS":
                                            echo "<span class='badge text-bg-light'>DS</span>";
                                            break;
                                        default:
                                            echo "<span class='badge text-bg-light'>$m[9]</span>";
                                            break;
                                    }

                                    ?></td>
                                <td class="text-center">
                                    <a href="javascript:void(0);"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="col-md-3">

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
                <div id="pdb" style="min-height: 400px; height:50vh; width:100%; min-width: 280px"></div>
                <p style="text-align: right"><a href="<?= base_url("/export/pymol/$id") ?>">Export to PyMOL</a></p>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="contactMap" tabindex="-1" aria-labelledby="contactMap" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3 text-center w-100" id="contactMapTitle"><strong>Contacts map for <?= $id ?></strong></h1>
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
                    canvas {
                        max-width: calc(100vh - 150px) !important;
                    }
                </style>
                <div class="row">

                    <div class="col">
                        <canvas id="scatterChart" class="p-4"></canvas>
                        <div id="legend" class="pb-3"></div>
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
<a href="#" title="Return to top" style="font-size:25px; position:fixed; right:10px; bottom:10px"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>

<script>
    function copyLink() {
        const link = '<?= base_url("/project/$id") ?>';
        // Cria um elemento <input> temporário
        const inputTemp = document.createElement("input");
        inputTemp.value = link;
        document.body.appendChild(inputTemp);

        // Seleciona o conteúdo e copia
        inputTemp.select();
        document.execCommand("copy");

        // Remove o input temporário
        document.body.removeChild(inputTemp);

        alert("Project link copied to clipboard!");
    }

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
    /* Select ID */
    function selectID(glviewer, residues, type, chain, a1, a2) {

        residues = residues.split("/");

        var res1 = residues[0].substr(1);
        var res2 = residues[1].substr(1);

        glviewer.setStyle({}, {
            line: {
                color: 'grey'
            },
            cartoon: {
                color: 'white'
            }
        }); /* Cartoon multi-color */
        glviewer.setStyle({
            resi: res1
        }, {
            stick: {
                colorscheme: 'whiteCarbon'
            }
        });
        glviewer.setStyle({
            resi: res2
        }, {
            stick: {
                colorscheme: 'whiteCarbon'
            }
        });

        glviewer.zoomTo({
            resi: [res1, res2],
            chain: chain
        });

        // linha tracejada
        let atm1 = glviewer.selectedAtoms({
            resi: res1,
            atom: a1
        }); // Resíduo 10, átomo O
        let atm2 = glviewer.selectedAtoms({
            resi: res2,
            atom: a2
        }); // Resíduo 20, átomo N

        // Garantir que os átomos foram encontrados antes de desenhar a linha
        if (atm1.length > 0 && atm2.length > 0) {
            var atom1 = atm1[0]; // Primeiro átomo correspondente
            var atom2 = atm2[0]; // Primeiro átomo correspondente

            // Adicionar a linha tracejada entre os átomos
            glviewer.addLine({
                dashed: true,
                start: {
                    x: atom1.x,
                    y: atom1.y,
                    z: atom1.z
                },
                end: {
                    x: atom2.x,
                    y: atom2.y,
                    z: atom2.z
                },
                color: "red",
                dashLength: 0.2, // Comprimento dos traços
                linewidth: 5, // Define a grossura da linha
                gapLength: 0.1
            });
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

    $(document).ready(function() {

        //var title_pdb = $(".title_h2").text();
        //title_pdb = title_pdb.split(": ")

        //var txt = "https://files.rcsb.org/download/"+title_pdb[1]+".pdb";
        var txt = "<?= base_url('/data/projects/' . $id . '/data.' . $extensao) ?>";

        $.post(txt, function(d) {

            moldata = data = d;

            /* Creating visualization */
            glviewer = $3Dmol.createViewer("pdb", {
                defaultcolors: $3Dmol.rasmolElementColors
            });

            /* Color background */
            glviewer.setBackgroundColor(0xffffff);

            receptorModel = m = glviewer.addModel(data, '<?= $extensao ?>');

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

<script>
    // tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


    // MAPA DE CONTATOS
    let allChains = new Set();
    let allDataPoints = [];
    let scatterChart;
    let colorMap = {};
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
        const filteredData = allDataPoints.filter(p => p.c1 === selectedX && p.c2 === selectedY);

        scatterChart.data.datasets[0].data = filteredData;
        scatterChart.data.datasets[0].pointBackgroundColor = filteredData.map(p => p.backgroundColor);
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

    fetch('<?php echo base_url("/data/projects/$id/contacts.csv"); ?>')
        .then(response => response.text())
        .then(text => {
            const lines = text.split('\n').map(line => line.trim()).filter(line => line);
            lines.shift(); // Ignorar a primeira linha
            let colorIndex = 0;
            let legendHTML = "<strong>Caption:</strong>";

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
                        legendHTML += `<div style='display: flex; align-items: center; gap: 5px;'>
                    <div style='width: 20px; height: 20px; background-color: ${colorMap[category]};'></div>${category}</div>`;
                        colorIndex++;
                    }

                    allDataPoints.push({
                        x,
                        y,
                        c1,
                        c2,
                        backgroundColor: colorMap[category],
                        label
                    });
                }
            });

            document.getElementById('legend').innerHTML = legendHTML;
            populateChainSelectors();

            const ctx = document.getElementById('scatterChart').getContext('2d');
            scatterChart = new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Dispersão CSV',
                        data: allDataPoints.filter(p => p.c1 === 'A' && p.c2 === 'A'),
                        pointBackgroundColor: allDataPoints.map(p => p.backgroundColor),
                        borderWidth: 0,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw.label;
                                }
                            }
                        },
                        legend: {
                            display: false
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
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Chain A'
                            },
                            beginAtZero: false,
                            min: 1,
                        }
                    }
                }
            });


        })
        .catch(error => console.error('Erro ao carregar o arquivo CSV:', error));
</script>
<?= $this->endSection() ?>