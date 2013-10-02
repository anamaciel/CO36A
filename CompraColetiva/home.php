<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("class/oferta.class.php");
require_once("class/usuario.class.php");

$banco = new cPDO();
$oferta = new oferta();
?>

<div class="content">
    <div class="container_12">
        <div class="grid_12">
            <h3>Top Ofertas</h3>
        </div>
        <div class="boxes">
            <?php
            $ofertas = new oferta();
            $verificaOferta = new oferta();
            $ofertas->set('start', 0);
            $ofertas->set('limit', 3);
            $sql = $ofertas->ListaOferta();
            //echo $sql;
            $cont = 1;
            foreach ($banco->query($sql) as $row) {
                $verificaOferta->set('id', $row['id']);
                $sqlVerifica = $verificaOferta->verificaStatusOferta();
                //echo $sqlVerifica;
                $row_oferta = $banco->query($sqlVerifica)->fetch();

                if ($row_oferta['dias'] > 0 && $row_oferta['status'] == 1) {
                    echo $row_oferta['status'];
                    $sqlFoto = "SELECT * FROM recursos WHERE oferta_id =" . $row['id'];
                    $row_foto = $banco->query($sqlFoto)->fetch();
                    ?>
                    <div class="grid_4">
                        <figure>
                            <div><img src="<?php echo $caminho . $row_foto['url']; ?>" alt="" width="360px" height="337px"></div>
                            <figcaption>
                                <h3>OFERTA</h3>
                                <?php echo $row['descricao']; ?>
                                <a href="<?php echo $caminho; ?>site/ofertaDetalhe/<?php echo $row['id']; ?>" class="btn">Detalhes</a>
                            </figcaption>
                        </figure>
                    </div>
                    <?php
                }
                $cont++;
            }
            ?>

            <!--            <div class="grid_4">
                            <figure>
                                <div><img src="<?php echo $caminho; ?>images/page1_img2.jpg" alt=""></div>
                                <figcaption>
                                    <h3>New York</h3>
                                    Psum dolor sit ametylo gerto consectetur ertori hykill holit adipiscing lity. Donecto rtopil osueremo	kollit asec emmodem geteq tiloli. Aliquam dapibus neclol nami wertoli elittro eget vulpoli no
                                    utaterbil congue turpis in su.
                                    <a href="" class="btn">Details</a>
            
                                </figcaption>
                            </figure>
                        </div>
                        <div class="grid_4">
                            <figure>
                                <div><img src="<?php echo $caminho; ?>images/page1_img3.jpg" alt=""></div>
                                <figcaption>
                                    <h3>Paris</h3>
                                    Lorem ipsum dolor site geril amet, consectetur cing eliti. Suspendisse nulla leo mew dignissim eu velite a rew qw vehicula lacinia arcufasec ro. Aenean lacinia ucibusy fase tortor ut feugiat. Rabi tur oliti aliquam bibendum olor quis malesuadivamu.
                                    <a href="" class="btn">Details</a>
                                </figcaption>
                            </figure>
                        </div>-->
            <div class="clear"></div>
        </div>



    </div>
</div>