<script>
    $(function() {
        //find all form with class jqtransform and apply the plugin
        $(".form1").jqTransform();
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
        <div class="grid_9">
            <h3>Ofertas Ativas</h3>
            <div class="tours">
                <?php
                $oferta = new oferta();
                $verificaOferta = new oferta();
                $sql = $oferta->ListaOferta();
                //echo $sql;
                foreach ($banco->query($sql) as $row) {
                    $verificaOferta->set('id', $row['id']);
                    $sqlVerifica = $verificaOferta->verificaStatusOferta();
                    //echo $sqlVerifica;
                    $row_oferta = $banco->query($sqlVerifica)->fetch();
                    //echo $row['status'] . 'teste';
                    if ($row_oferta['dias'] > 0 && $row['status'] == '1') {
                        ?>
                        <div class="grid_4 alpha">
                            <div class="tour">
                                <?php
                                $sqlFoto = "SELECT * FROM recursos WHERE oferta_id = ". $row['id'];
                                //echo $sqlFoto;
                                $row_foto = $banco->query($sqlFoto)->fetch();
                                ?>
                                <img src="<?php echo $caminho . $row_foto['url']; ?>" alt="" class="img_inner fleft" width="167px" height="143px">
                                <div class="extra_wrapper">
                                    <p class="text1"><?php echo $row['nome']; ?></p>
                                    <p class="price"><span>De R$<?php echo formata_valor($row['valor_real'], 2); ?></span></p>
                                    <p class="price"><span>Por R$<?php echo formata_valor($row['valor_liquido'], 2); ?></span></p>
                                    <a href="<?php echo $caminho; ?>site/ofertaDetalhe/<?php echo $row['id']; ?>" class="btn">Detalhes</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <!--        <div class="grid_3">
                    <h3>Browse Tours</h3>
                    <form method="post" id="form1" class="form1">
                        <label class="mb0">
                            <span>Browse by Tour Operator</span>
                            <select name="select">
                                <option value="">Browse by Tour Operator</option>
                                <option value="">...</option>
                            </select>
                        </label>
                        <div class="clear"></div>
                        <a onClick="document.getElementById('form1').submit()" href="#" class="btn"> Search</a>
                    </form> 
                    <h3>Search Tours</h3>
                    <form method="post" id="form2" class="form1">
                        <label >
                            <span><span class="col1">All Tour Operators</span><br>Destination</span>
                            <select name="select">
                                <option value="">Any destination</option>
                                <option value="">...</option>
                            </select>
                        </label>
                        <label >
                            <span>Departing</span>
                            <select name="select">
                                <option value="">Any departing</option>
                                <option value="">...</option>
                            </select>
                        </label>
                        <label>
                            <span>Price</span>
                            <select name="select">
                                <option value="">Any price</option>
                                <option value="">...</option>
                            </select>
                        </label>
                        <label class="mb0">
                            <span>Duration</span>
                            <select name="select">
                                <option value="">Any duration</option>
                                <option value="">...</option>
                            </select>
                        </label>
                        <div class="clear"></div>
                        <a onClick="document.getElementById('form2').submit()" href="#" class="btn"> Search</a>
                    </form> 
                </div>-->
        <div class="clear"></div>
    </div>
</div>