<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->
<div class="container py-5">

    <h1 class="pb-5 text-dark">Explore</h1>

    <div id="explore">
        <div class="container">
            <table id="table_explore" class="table table-striped table-hover" style="width:100%; ">
                <thead>
                    <tr class="tableheader">
                        <th class="dt-center">RpID <sup><a class="tip" href="#" data-placement="top" data-toggle="tooltip" title="PDB - RNA chain - PROTEIN chain">?</a></sup></th>
                        <th class="dt-center">Title <sup><a class="tip" href="#" data-placement="top" data-toggle="tooltip" title="Name">?</a></sup></th>
                        <th class="dt-center">Description <sup><a class="tip" href="#" data-placement="top" data-toggle="tooltip" title="Description of the pdb file">?</a></sup></th>
                        <th>RNA size</th>
                        <th>Protein size</th>
                        <th class="dt-center">Contacts <sup><a class="tip" href="#" data-placement="top" data-toggle="tooltip" title="Number of contacts">?</a></sup></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    $(() => {


        const lerDados = (arquivo) => {

            // ler arquivo usando jQuery
            $.ajax({
                url: arquivo,
                success: (dados) => {
                    dados_formatados = formatarTabela(dados)

                    plotar(dados_formatados)
                }
            });
        }

        // formatar tabela --> INÍCIO 
        const formatarTabela = (dados) => {

            let dados_tabelados = [];

            // separa as linhas
            let linhas = dados.split("\n")

            // para cada linha
            for (let linha of linhas) {

                // remove caracteres especiais 
                linha = linha.replace("\r", "")

                // separa as células
                celulas = linha.split("\t")

                celulas[0] = `<strong><a href="/entry/${celulas[0]}">${celulas[0]}</a></strong>`;

                // salva células
                dados_tabelados.push(celulas)
            }

            return dados_tabelados
        }
        // formatar tabela --> FIM 


        // plotando a tabela
        const plotar = (dados) => {

            console.log(dados)

            // ativar datatable
            $("#table_explore").DataTable({
                "data": dados,
                // "order": [
                //     [0, 'asc']
                // ] // ordena pela coluna 0
            })
        }

        lerDados("<?= base_url('data/rnapedia_database.tsv') ?>");

    })

    
</script>
<?= $this->endSection() ?>