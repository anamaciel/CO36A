<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//error_reporting(E_ALL);

require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("class/oferta.class.php");

$id = anti_injection($id);

$banco = new cPDO();
$oferta = new oferta();
$oferta->set('id', $id);
$sql = $oferta->ListaOferta();
$row_oferta = $banco->query($sql)->fetch();
?>
<div class="content">
    <div class="container_12">
        <div class="grid_9">
            <div class="">
                <h3><?php echo $row_oferta['nome']; ?></h3>
                <div class="tempo">Tempo restante</div>
                <div id="tempoRestante"></div>
                <img src="<?php echo $caminho; ?>images/page2_img1.jpg" alt="" class="img_inner fleft">
                <p class="text1"><?php echo $row_oferta['descricao']; ?></p>
                <div class="clear"></div>
            </div>
        </div>
        <div class="grid_3">
            <h3>Ofertas Ativas</h3>
            <ul class="list1">
                <?php
                $ofertas = new oferta();
                $ofertas->set('start', 0);
                $ofertas->set('limit', 3);
                $sql = $ofertas->ListaOferta();
                $cont = 1;
                foreach ($banco->query($sql) as $row) {
                    ?>
                    <li>
                        <div class="count"><?php echo $cont; ?></div>
                        <div class="extra_wrapper">
                            <div class="text1"><a href="<?php echo $caminho; ?>site/ofertaDetalhe/<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></a></div><?php echo $row['descricao']; ?>
                        </div>
                    </li>
                    <?php
                    $cont++;
                }
                ?>
            </ul>
        </div>
        <div class="clear"></div>
        <div class="grid_12">
            <div class="hor_sep"></div>
        </div>
        <div class="clear"></div>

    </div>
</div>
<script type="text/javascript">
    var socket = io.connect('http://localhost:8088', {
        'connect timeout': 500,
        'reconnect': true,
        'reconnection delay': 500,
        'reopen delay': 500,
        'max reconnection attempts': 10
    })
    socket.emit("userconected", "<?php echo $id; ?>");
    socket.on("showmessage", function(a) {
        document.getElementById("tempoRestante").innerHTML = a.mensagem;
    });
    //socket.on("showmessage",function(a){document.getElementById("hora").innerHTML=a.hora});
</script>