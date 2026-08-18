<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<style>
    /* Dual-range slider (min/max num único controle) */
    .range-slider { position: relative; height: 26px; }
    .range-slider .slider-track { position: absolute; height: 5px; background: #dee2e6; width: 100%; top: 10px; border-radius: 5px; }
    .range-slider .track-fill { position: absolute; height: 5px; background: #0d6efd; top: 10px; border-radius: 5px; }
    .range-slider input[type=range] {
        position: absolute; width: 100%; top: 6px; height: 5px; margin: 0;
        background: none; pointer-events: none;
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
    }
    .range-slider input[type=range]::-webkit-slider-runnable-track { background: none; border: none; }
    .range-slider input[type=range]::-moz-range-track { background: none; border: none; }
    .range-slider input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none; appearance: none; pointer-events: auto;
        height: 15px; width: 15px; border-radius: 50%; background: #0d6efd;
        border: 2px solid #fff; box-shadow: 0 0 3px rgba(0,0,0,.45); cursor: pointer; margin-top: -5px;
    }
    .range-slider input[type=range]::-moz-range-thumb {
        pointer-events: auto; height: 15px; width: 15px; border-radius: 50%;
        background: #0d6efd; border: 2px solid #fff; cursor: pointer;
    }
    /* Chevron do toggle do card de filtros */
    .filters-toggle .chevron { transition: transform .2s; }
    .filters-toggle[aria-expanded="false"] .chevron { transform: rotate(-90deg); }
</style>

<div class="container-fluid py-5 px-5">

    <div class="d-flex flex-wrap align-items-center justify-content-between pb-4">
        <h1 class="text-dark mb-0">Advanced search</h1>
        <a href="<?= base_url('explore') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-return-left"></i> Back to Explore
        </a>
    </div>

    <p class="text-muted">
        Search the full COCα​DA-web dataset by structure properties. Combine text search,
        the biological assembly flag and numeric ranges for residues, contacts, pH and each
        contact type.
    </p>

    <!-- PAINEL DE BUSCA AVANÇADA -->
    <div class="card mb-4" id="advancedFilters">
        <div class="card-header bg-light d-flex align-items-center justify-content-between">
            <button class="btn btn-sm btn-link text-decoration-none p-0 text-dark filters-toggle" type="button"
                data-bs-toggle="collapse" data-bs-target="#filtersBody" aria-expanded="true" aria-controls="filtersBody">
                <i class="bi bi-funnel-fill me-1"></i> <strong>Filters</strong>
                <i class="bi bi-chevron-down ms-1 chevron"></i>
            </button>
            <div>
                <button type="button" id="btnApply" class="btn btn-sm btn-primary">
                    <i class="bi bi-search"></i> Apply filters
                </button>
                <button type="button" id="btnReset" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Reset
                </button>
                <button type="button" id="btnExport" class="btn btn-sm btn-success">
                    <i class="bi bi-filetype-csv"></i> Download CSV
                </button>
            </div>
        </div>
        <div class="card-body collapse show" id="filtersBody">

            <!-- Filtros de texto -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label small mb-1" for="f_id">PDB ID contains</label>
                    <input type="text" class="form-control form-control-sm" id="f_id" placeholder="e.g. 2LZM, 1A00 4HHB">
                    <div class="form-text small">One or more IDs, separated by comma or space.</div>
                </div>
                <div class="col-md-5">
                    <label class="form-label small mb-1" for="f_desc">Description contains</label>
                    <input type="text" class="form-control form-control-sm" id="f_desc" placeholder="e.g. lysozyme">
                </div>
                <div class="col-md-3">
                    <label class="form-label small mb-1" for="f_ba">Biological assembly</label>
                    <select class="form-select form-select-sm" id="f_ba">
                        <option value="">All</option>
                        <option value="Yes">Yes (has assembly)</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>

            <hr class="my-2">
            <p class="small text-muted mb-2">Numeric ranges — drag each slider (from 0 to the maximum available):</p>

            <!-- Filtros numéricos (dual-range sliders) -->
            <div class="row g-3">
                <?php
                // [rótulo, id-base, coluna, sigla (badge) ou null, classe de cor do badge]
                // As cores dos badges seguem as usadas na página entry para cada tipo de contato.
                $ranges = [
                    ['Residues', 'res', 2,  null,  null],
                    ['Contacts', 'con', 3,  null,  null],
                    ['pH',       'ph',  14, null,  null],
                    ['Hydrogen bond contacts:',      'hb',  4,  'HB',  'text-bg-success'],
                    ['Hydrophobic contacts:',        'hy',  5,  'HY',  'text-bg-warning'],
                    ['Attractive contacts:',         'at',  6,  'AT',  'text-bg-info'],
                    ['Repulsive contacts:',          're',  7,  'RE',  'text-bg-danger'],
                    ['Salt bridge contacts:',        'sb',  8,  'SB',  'text-bg-primary'],
                    ['Disulfide bond contacts:',     'ds',  9,  'DS',  'text-bg-dark'],
                    ['Aromatic stacking contacts:',  'as',  10, 'AS',  'text-bg-secondary'],
                    ['Uncertain attractive contacts:',   'uat', 11, 'uAT', 'text-bg-light border'],
                    ['Uncertain repulsive contacts:',    'ure', 12, 'uRE', 'text-bg-light border'],
                    ['Uncertain salt bridge contacts:',  'usb', 13, 'uSB', 'text-bg-light border'],
                ];
                foreach ($ranges as $r):
                    $col   = $r[2];
                    $badge = $r[3];
                    $step  = ($col === 14) ? '0.1' : '1'; // pH tem casas decimais
                    $hi    = isset($maxes[$col]) ? $maxes[$col] : 0;
                    ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-1">
                        <label class="form-label small mb-1">
                            <?php if ($badge): ?><span class="badge <?= $r[4] ?> me-1"><?= $badge ?></span><?php endif; ?>
                            <?= $r[0] ?>
                        </label>
                        <div class="range-slider" data-lo="0" data-hi="<?= $hi ?>">
                            <div class="slider-track"></div>
                            <div class="track-fill"></div>
                            <input type="range" class="range-min" id="f_<?= $r[1] ?>_min" min="0" max="<?= $hi ?>" value="0" step="<?= $step ?>">
                            <input type="range" class="range-max" id="f_<?= $r[1] ?>_max" min="0" max="<?= $hi ?>" value="<?= $hi ?>" step="<?= $step ?>">
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span class="val-min fw-semibold text-dark">0</span>
                            <span class="val-max fw-semibold text-dark"><?= $hi ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <!-- TABELA -->
    <div id="advanced">
        <div class="table-responsive">
            <table id="table_advanced" class="table table-striped table-hover small" style="width:100%;">
                <thead>
                    <tr class="tableheader">
                        <th class="dt-center">PDB ID</th>
                        <th class="dt-center">Description</th>
                        <th>Residues</th>
                        <th>Contacts</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Hydrogen Bonds">HB</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Hydrophobic">HY</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Attractive">AT</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Repulsive">RE</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Salt Bridge">SB</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Disulfide Bond">DS</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Aromatic Stacking">AS</th>
                        <th data-bs-toggle="tooltip" data-bs-title="uncertain Attractive">uAT</th>
                        <th data-bs-toggle="tooltip" data-bs-title="uncertain Repulsive">uRE</th>
                        <th data-bs-toggle="tooltip" data-bs-title="uncertain Salt Bridge">uSB</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Deposited pH value (default = 7.4)">pH</th>
                        <th data-bs-toggle="tooltip" data-bs-title="Biological Assembly 1 different from Asymmetric Unit">BA</th>
                        <th class="dt-center">PDB</th>
                        <th class="dt-center">Contacts file</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <p class="small text-muted text-center" id="loading_table">Loading data. Please wait...<br><img src="<?= base_url('/img/loading.gif') ?>" width="25px" class="mt-2"></p>

        <!-- Cópia grande do botão de export, no fim da tabela -->
        <div class="text-center my-4">
            <button type="button" id="btnExportBottom" class="btn btn-success btn-lg">
                <i class="bi bi-filetype-csv"></i> Download table as CSV
            </button>
        </div>
    </div>

    <!-- FILTRAR A BASE COMPLETA LOCALMENTE (Zenodo + Python) -->
    <div class="card mt-5">
        <div class="card-header bg-light">
            <strong><i class="bi bi-filetype-py me-1"></i> Download &amp; filter the full dataset locally</strong>
        </div>
        <div class="card-body">
            <p>
                The <strong>Download CSV</strong> button above exports the summary table for your current filters.
                To retrieve the actual contact/info files of the selected structures, download the complete database
                (hosted on Zenodo) and filter it locally &mdash; generating custom download packages on our server is
                too resource-intensive. The <a href="<?= base_url('download') ?>">Download page</a> always links to the
                most recent Zenodo release.
            </p>
            <p class="small text-muted mb-2">
                Run the script below in <a href="https://colab.research.google.com" target="_blank" rel="noopener">Google Colab</a>
                or any local Python environment (requires <code>pandas</code>). It keeps only the entries matching the filters
                you selected above &mdash; click <strong>Apply filters</strong> to refresh it. The database folders are organized as
                <code>pdb/&lt;first_char&gt;/&lt;ID&gt;/&lt;ID&gt;_contacts.csv</code> (and <code>_info.csv</code>).
            </p>
            <div class="position-relative">
                <button id="btnCopyPy" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2">
                    <i class="bi bi-clipboard"></i> Copy
                </button>
                <pre class="bg-dark text-light p-3 rounded" style="overflow:auto; max-height:460px;"><code id="pyScript"></code></pre>
            </div>
        </div>
    </div>

</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(() => {
        const BASE_URL = '<?= base_url() ?>';

        // Colunas numéricas: índice na tabela -> id-base dos inputs min/max
        const numericFilters = [
            { col: 2,  id: 'res' },
            { col: 3,  id: 'con' },
            { col: 14, id: 'ph'  },
            { col: 4,  id: 'hb'  },
            { col: 5,  id: 'hy'  },
            { col: 6,  id: 'at'  },
            { col: 7,  id: 're'  },
            { col: 8,  id: 'sb'  },
            { col: 9,  id: 'ds'  },
            { col: 10, id: 'as'  },
            { col: 11, id: 'uat' },
            { col: 12, id: 'ure' },
            { col: 13, id: 'usb' },
        ];

        const getVal = (id) => (document.getElementById(id).value || '').trim();

        // ---- Dual-range sliders (min/max) ----
        const sliders = [];
        function initRangeSlider(el) {
            const lo = parseFloat(el.dataset.lo);
            const hi = parseFloat(el.dataset.hi);
            const range = (hi - lo) || 1;
            const inMin = el.querySelector('.range-min');
            const inMax = el.querySelector('.range-max');
            const fill = el.querySelector('.track-fill');
            const vMin = el.parentElement.querySelector('.val-min');
            const vMax = el.parentElement.querySelector('.val-max');
            const pct = (v) => ((v - lo) / range) * 100;
            function update() {
                let a = parseFloat(inMin.value);
                let b = parseFloat(inMax.value);
                if (a > b) { // impede que os thumbs cruzem
                    if (document.activeElement === inMin) { a = b; inMin.value = a; }
                    else { b = a; inMax.value = b; }
                }
                fill.style.left = pct(a) + '%';
                fill.style.right = (100 - pct(b)) + '%';
                vMin.textContent = a;
                vMax.textContent = b;
            }
            inMin.addEventListener('input', update);
            inMax.addEventListener('input', update);
            update();
            sliders.push({ inMin, inMax, lo, hi, update });
        }
        document.querySelectorAll('.range-slider').forEach(initRangeSlider);

        // Coleta só os ranges realmente ajustados (min > 0 ou max < máximo do campo),
        // para o padrão (tudo no extremo) não filtrar nada e usar o caminho rápido.
        function collectRanges() {
            const out = {};
            numericFilters.forEach((f) => {
                const minEl = document.getElementById('f_' + f.id + '_min');
                const maxEl = document.getElementById('f_' + f.id + '_max');
                const minV = parseFloat(minEl.value);
                const maxV = parseFloat(maxEl.value);
                const fieldMax = parseFloat(maxEl.max);
                const r = {};
                if (minV > 0) { r.min = minV; }
                if (maxV < fieldMax) { r.max = maxV; }
                if (r.min !== undefined || r.max !== undefined) { out[f.col] = r; }
            });
            return out;
        }

        // ---- Gera o script Python que reproduz os filtros atuais ----
        const colName = {
            2: 'Num_Residues', 3: 'Num_Contacts', 14: 'pH',
            4: 'HB', 5: 'HY', 6: 'AT', 7: 'RE', 8: 'SB', 9: 'DS',
            10: 'AS', 11: 'uAT', 12: 'uRE', 13: 'uSB'
        };
        const py = (s) => JSON.stringify(String(s)); // literal de string válido em Python

        function buildPythonScript() {
            const L = [];
            L.push('import pandas as pd, os, shutil');
            L.push('');
            L.push('# Summary table from the Zenodo download');
            L.push('cols = ["ID","Description","Num_Residues","Num_Contacts","HB","HY","AT","RE",');
            L.push('        "SB","DS","AS","uAT","uRE","uSB","pH","Biological_Assembly"]');
            L.push('df = pd.read_csv("advanced_list.csv", header=None, names=cols)');
            L.push('');
            L.push('# --- Filters (matching your current selection on the website) ---');
            L.push('mask = pd.Series(True, index=df.index)');

            const fId = getVal('f_id');
            if (fId) {
                // lista separada por vírgula/espaço -> casa qualquer um (regex "a|b|c")
                const pattern = fId.split(/[\s,]+/).filter(Boolean).join('|');
                L.push('mask &= df["ID"].str.contains(' + py(pattern) + ', case=False, na=False, regex=True)');
            }
            const fDesc = getVal('f_desc');
            if (fDesc) { L.push('mask &= df["Description"].str.contains(' + py(fDesc) + ', case=False, na=False)'); }
            const fBa = getVal('f_ba');
            if (fBa) { L.push('mask &= df["Biological_Assembly"] == ' + py(fBa)); }
            const q = table.search();
            if (q) { L.push('mask &= df.astype(str).apply(lambda r: ' + py(q.toLowerCase()) + ' in ",".join(r.values).lower(), axis=1)'); }

            const ranges = collectRanges();
            Object.keys(ranges).forEach((col) => {
                const name = colName[col];
                const r = ranges[col];
                if (r.min !== undefined && r.max !== undefined) {
                    L.push('mask &= df["' + name + '"].between(' + r.min + ', ' + r.max + ')');
                } else if (r.min !== undefined) {
                    L.push('mask &= df["' + name + '"] >= ' + r.min);
                } else if (r.max !== undefined) {
                    L.push('mask &= df["' + name + '"] <= ' + r.max);
                }
            });

            L.push('');
            L.push('selected = df[mask]');
            L.push('print(f"{len(selected)} structures selected")');
            L.push('selected.to_csv("filtered_list.csv", index=False)');
            L.push('');
            L.push('# --- Copy the matching entries (folder layout: pdb/<first_char>/<ID>/) ---');
            L.push('for pid in selected["ID"]:');
            L.push('    src = os.path.join("pdb", pid[0], pid)');
            L.push('    dst = os.path.join("filtered_pdb", pid[0], pid)');
            L.push('    if os.path.isdir(src):');
            L.push('        shutil.copytree(src, dst, dirs_exist_ok=True)');
            return L.join('\n');
        }

        function updatePythonScript() {
            document.getElementById('pyScript').textContent = buildPythonScript();
        }

        // DataTables em modo server-side: o PHP lê o CSV e devolve só a página
        // pedida (busca/filtros/ordenação/paginação são feitos no servidor).
        const table = $('#table_advanced').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 400, // evita disparar a cada tecla na busca global
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: BASE_URL + 'advanced-search/data',
                data: function(d) {
                    // filtros customizados enviados junto dos parâmetros do DataTables
                    d.f_id = getVal('f_id');
                    d.f_desc = getVal('f_desc');
                    d.f_ba = getVal('f_ba');
                    d.ranges = collectRanges();
                }
            },
            columnDefs: [
                {
                    // PDB ID -> link para a página da entry
                    targets: 0,
                    render: function(data, type) {
                        if (type === 'display') {
                            return `<strong><a href="${BASE_URL}entry/${data}">${data}</a></strong>`;
                        }
                        return data;
                    }
                },
                {
                    // Biological assembly: "Yes" vira link para a página do assembly
                    targets: 15,
                    render: function(data, type, row) {
                        const v = (String(data).trim().toLowerCase() === 'yes') ? 'Yes' : 'No';
                        if (type === 'display') {
                            return v === 'Yes'
                                ? `<a href="${BASE_URL}assembly/${row[0]}" class="badge text-bg-success text-decoration-none">Yes <i class="bi bi-box-arrow-up-right"></i></a>`
                                : `<span class="badge text-bg-secondary">No</span>`;
                        }
                        return v;
                    }
                },
                {
                    // Coluna extra: download do PDB direto do RCSB
                    targets: 16,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    render: function(data, type, row) {
                        return `<a class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener" title="Download PDB file from RCSB" href="https://files.rcsb.org/download/${row[0]}.pdb"><i class="bi bi-download"></i> PDB</a>`;
                    }
                },
                {
                    // Coluna extra: download da lista de contatos (mesmo link da entry)
                    targets: 17,
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'dt-center',
                    render: function(data, type, row) {
                        const id = row[0];
                        return `<a class="btn btn-sm btn-outline-secondary" title="Download the contacts CSV" href="${BASE_URL}data/pdb/${id.charAt(0)}/${id}/${id}_contacts.csv"><i class="bi bi-download"></i> Contacts</a>`;
                    }
                }
            ],
            initComplete: function() {
                $('#loading_table').hide();
            }
        });

        updatePythonScript(); // script inicial (sem filtros)

        // Aplicar filtros -> recarrega a página atual do servidor
        $('#btnApply').on('click', function() {
            table.ajax.reload();
            updatePythonScript();
        });

        // Enter em qualquer input do painel aplica os filtros
        $('#advancedFilters').on('keydown', 'input', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                table.ajax.reload();
                updatePythonScript();
            }
        });

        // Resetar filtros (inclui voltar os sliders aos extremos)
        $('#btnReset').on('click', function() {
            document.getElementById('f_id').value = '';
            document.getElementById('f_desc').value = '';
            document.getElementById('f_ba').value = '';
            sliders.forEach((s) => {
                s.inMin.value = s.lo;
                s.inMax.value = s.hi;
                s.update();
            });
            table.search('');       // limpa a busca global
            table.ajax.reload();
            updatePythonScript();
        });

        // Copiar o script Python
        $('#btnCopyPy').on('click', function() {
            const code = document.getElementById('pyScript').textContent;
            const btn = $(this);
            const original = btn.html();
            navigator.clipboard.writeText(code).then(() => {
                btn.html('<i class="bi bi-check2"></i> Copied!');
                setTimeout(() => btn.html(original), 1500);
            });
        });

        // Download CSV: exporta TODOS os resultados que casam com os filtros atuais
        function exportCsv() {
            const p = new URLSearchParams();
            p.set('f_id', getVal('f_id'));
            p.set('f_desc', getVal('f_desc'));
            p.set('f_ba', getVal('f_ba'));
            p.set('search', table.search() || '');
            const ord = table.order()[0];
            if (ord) {
                p.set('order_col', ord[0]);
                p.set('order_dir', ord[1]);
            }
            const ranges = collectRanges();
            Object.keys(ranges).forEach((col) => {
                if (ranges[col].min !== undefined) { p.set('ranges[' + col + '][min]', ranges[col].min); }
                if (ranges[col].max !== undefined) { p.set('ranges[' + col + '][max]', ranges[col].max); }
            });
            window.location = BASE_URL + 'advanced-search/export?' + p.toString();
        }
        $('#btnExport').on('click', exportCsv);
        $('#btnExportBottom').on('click', exportCsv);
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
<?= $this->endSection() ?>
