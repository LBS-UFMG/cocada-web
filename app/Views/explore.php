<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container-fluid py-5 px-5">

    <div class="d-flex flex-wrap align-items-center justify-content-between pb-5">
        <h1 class="text-dark mb-0">Explore</h1>
        <a href="<?= base_url('advanced-search') ?>" class="btn btn-outline-primary">
            <i class="bi bi-sliders"></i> Advanced search
        </a>
    </div>

    <div id="explore">
        <div class="container-fluid">
            <table id="table_explore" class="table table-striped table-hover" style="width:100%; ">
                <thead>
                    <tr class="tableheader">
                        <th class="dt-center">PDB ID <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="PDB - ID">?</a></sup></th>
                        <th class="dt-center">Description <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Description of the pdb file">?</a></sup></th>
                        <th class="dt-center">Protein Size <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Size of the protein in residues">?</a></sup></th>
                        <th class="dt-center">Contacts <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Number of contacts calculated by COCaDA">?</a></sup></th>
                        <th class="dt-center">pH <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Deposited pH value (default = 7.4)">?</a></sup></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p class="small text-muted text-center" id="loading_table">Loading data. Please wait...<br><img src="<?=base_url('/img/loading.gif')?>" width="25px" class="mt-2"></p>

        </div>
    </div>

</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(() => {
        const BASE_URL = '<?= base_url() ?>';

        // captura o parâmetro de busca da URL (?q= ou ?query=)
        const urlParams = new URLSearchParams(window.location.search);
        const initialQuery = (urlParams.get('q') || urlParams.get('query') || '').trim();

        // DataTables server-side: o PHP lê o list.csv e devolve só a página pedida
        // (busca/ordenação/paginação são feitas no servidor, sem banco de dados).
        $('#table_explore').DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 400,
            pageLength: 10,
            order: [[0, 'asc']],
            search: { search: initialQuery }, // aplica o ?q= já na primeira carga
            ajax: {
                url: BASE_URL + 'explore/data'
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
                }
            ],
            initComplete: function() {
                $('#loading_table').hide();
            }
        });
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
