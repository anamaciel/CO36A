<script>
    $(function() {
        // Initialize the gallery
        $('.gallery a.gal').touchTouch();
    });
</script>

<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//error_reporting(E_ALL);


require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("class/oferta.class.php");

$banco = new cPDO();
?>

<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <h3>Ofertas Passadas</h3>
        </div>
        <div class="clear"></div>
        <div class="gallery">

            <?php
            $ofertaPassada = new oferta();
            // Setar qual é id de oferta finalizada
            $ofertaPassada->set(status, '2');

            $sql = $ofertaPassada->ListaOferta();

            $counter = 0;

            foreach ($banco->query($sql) as $row) {
                $sqlFoto = $ofertaPassada->ListaFotoOferta($row['id']);
                $row_foto = $banco->query($sqlFoto)->fetch();

                $counter++;
                ?>

                <div class="grid_4">
                    <a href="<?php echo $caminho . $row_foto['url']; ?>" class="gal img_inner"><img src="<?php echo $caminho . $row_foto['url']; ?>" alt=""></a>
                </div>

                <?php
                if ($counter == 3) {
                    echo "<div class=\"clear\"></div>";
                    $counter = 0;
                }
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
