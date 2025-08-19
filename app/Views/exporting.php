<?= $this->extend('template') ?>
<?= $this->section('conteudo') ?>
<!-- Conteúdo personalizado -->

<div class="container py-5 text-secondary text-center">
    <div class="row">
        <div class="col-3">
            <img src="<?= base_url('img/cocadito.png'); ?>" width="300px" class="rounded">
        </div>
        <div class="col">
        <p class="mt-4 alert alert-success"><b>Project exported to PyMOL – </b>ID: <a href="<?=base_url('/project/'.$id)?>"><?=$id?></a></p>

        <h1>Exporting</h1>
        <p>Making a Cocada... wait... ready!</p>
        <p><a href='<?=base_url("/data/projects/$id/contacts.pse")?>'>Download PSE file</a></p>
        <p>You will be redirected to the project page in <br><span id="contador" style="font-size: 50px;">10</span></h1>

        <hr>
            <h2>PyMOL color scheme</h2>
<code>
'HY': 'red',    # Hydrophobic
'HB': 'blue',   # Hydrogen Bond
'AT': 'green',  # Attractive
'RE': 'orange', # Repulsive
'SB': 'pink',   # Salt Bridge
'DS': 'purple'  # Disulfide Bond
</code>
        </div>
    </div>

</div>


<script>

    <?php $fileUrl = base_url("/data/projects/$id/contacts.pse"); ?>

    // Função para o redirecionamento
    function redirecionar() {
        window.location.href = "<?=base_url('/project/'.$id)?>";
    }

    // Função para o contador
    function iniciarContagem() {
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
    window.onload = function () {
        // URL do arquivo gerada no PHP
        const fileUrl = "<?= $fileUrl ?>";

        // Cria link temporário para download
        const link = document.createElement('a');
        link.href = fileUrl;
        link.download = ''; // Browser decide o nome do arquivo
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };

    window.onload = iniciarContagem;

</script>


<!-- / FIM Conteúdo personalizado -->
<?= $this->endSection() ?>
