<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div id="loading">
    <div class="text-center">
        <img src="<?=base_url('/img/cocadito-loading.png')?>" width="200px"><br>
        <div class="spinner-border spinner-border-sm" role="status"></div>
        <strong class="ms-2">Loading...</strong>
    </div>
</div>

<div class="container-fluid py-5 px-5">

    <h1 class="pb-5 text-dark">Explore</h1>

    <div id="explore">
        <div class="container-fluid">
            <table id="table_explore" class="table table-striped table-hover" style="width:100%; ">
                <thead>
                    <tr class="tableheader">
                        <th class="dt-center">PDB ID <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="PDB - ID">?</a></sup></th>
                        
                        <th class="dt-center">Description <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Description of the pdb file">?</a></sup></th>
                        <th>Protein size</th>
                        <th class="dt-center">Contacts <sup><a class="badge bg-dark" href="#" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-title="Number of contacts calculated by COCaDA">?</a></sup></th>
                        <th>pH</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p class="small text-muted text-center" id="loading_table">Loading data. Please wait...<br><img src="<?=base_url('/img/loading.gif')?>"></p>

        </div>
    </div>

</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(() => {
        // Base URL gerada pelo servidor (útil para templates)
        const BASE_URL = '<?= base_url() ?>';

        // captura o parâmetro de busca da URL (?q= ou ?query=)
        const urlParams = new URLSearchParams(window.location.search);
        const initialQuery = (urlParams.get('q') || urlParams.get('query') || '').trim();

        const lerDados = (arquivo) => {
            $.ajax({
                url: arquivo,
                dataType: 'text',
                success: (dados) => {
                    try {
                        const dados_formatados = formatarTabela(dados);
                        plotar(dados_formatados, initialQuery);
                    } catch (err) {
                        console.error('Erro ao processar dados:', err);
                    }
                },
                error: (xhr, status, err) => {
                    console.error('Erro na requisição AJAX:', status, err);
                }
            });
        };

        // formatar tabela --> INÍCIO 
        const formatarTabela = (dados) => {
            let dados_tabelados = [];
            let linhas = dados.split("\n") // separa as linhas
            for (let linha of linhas) {  // para cada linha
                linha = linha.replace("\r", "") // remove caracteres especiais 
                if(linha!=""){ // separa as células
                    celulas = linha.split(",")
                }
                celulas[0] = `<strong><a href="<?=base_url()?>/entry/${celulas[0]}">${celulas[0]}</a></strong>`;

                dados_tabelados.push(celulas) // salva células
            }
            return dados_tabelados
        }
        // formatar tabela --> FIM 

        // plotando a tabela
        const plotar = (dados, initialSearch = '') => {
            // destrói se já existir DataTable
            if ($.fn.DataTable.isDataTable('#table_explore')) {
                $('#table_explore').DataTable().clear().destroy();
                $('#table_explore tbody').empty();
            }
            
            // ativar datatable
            const table = $("#table_explore").DataTable({
                "data": dados,
                // "order": [
                //     [0, 'asc']
                // ] // ordena pela coluna 0
                initComplete: function(settings, json) {
                    $("#loading_table").hide();
                }
            })

            if (initialSearch) {
                // define valor no input de busca (interface)
                const filterInput = $('#table_explore_filter input');
                if (filterInput.length) filterInput.val(initialSearch);

                // aplica a busca e redesenha
                table.search(initialSearch).draw();
            }

        }
        lerDados("<?= base_url('data/pdb/list.csv') ?>");
    })

</script>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
        $(()=>setTimeout(() => $('#loading').fadeOut(), 1000));

// tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
</script>
<?= $this->endSection() ?>
