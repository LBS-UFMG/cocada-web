<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container py-5 text-secondary text-center">
    <div class="row">
        <div class="col-3">
            <img src="<?= base_url('img/cocadito.png'); ?>" width="300px" class="rounded">
        </div>
        <div class="col">

            <h1>Exporting</h1>
            <p>Making a Cocada... wait... ready!</p>
            <p>If the download does not start automatically, click here to <a id="pse" href='
            <?php if (strlen($id) == 6) {
                echo base_url("/data/projects/$id/contacts.pse");
            } else {
                echo base_url("/data/pdb/$id[0]/$id/$id" . "_contacts.pse");
            } ?>
            '>Download the PSE file</a>.</p>
            <p>You will be redirected to the project page in <br><span id="contador" style="font-size: 50px;">10</span></h1>

                <hr>
            <h2>PyMOL color scheme</h2>
            <code>
                'HY': 'red', # Hydrophobic
                'HB': 'blue', # Hydrogen Bond
                'AT': 'green', # Attractive
                'RE': 'orange', # Repulsive
                'SB': 'pink', # Salt Bridge
                'DS': 'purple' # Disulfide Bond
            </code>
        </div>
    </div>

</div>


<script>
    // Função para o redirecionamento
    function redirecionar() {
        window.location.href = "<?php if (strlen($id) == 6) echo base_url('/project/' . $id);
                                else echo base_url('/entry/' . $id); ?>";
    }

    // Função para o contador
    function iniciarContagem() {
        console.log("contagem começou");
        let tempoRestante = 10; // 5 segundos
        const contadorElemento = document.getElementById("contador");

        const intervalo = setInterval(() => {
            contadorElemento.textContent = tempoRestante;
            tempoRestante--;

            if (tempoRestante < 0) {
                clearInterval(intervalo);
                redirecionar(); // Redireciona ao final da contagem
            }
        }, 1000); // Atualiza a cada 1 segundo
    }

    // Inicia a contagem quando a página for carregada
    window.onload = function() {
        // Cria link temporário para download
        console.log("Página carregada");
        const link = document.querySelector("#pse");
        link.click();
        iniciarContagem();
    };
</script>


<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>