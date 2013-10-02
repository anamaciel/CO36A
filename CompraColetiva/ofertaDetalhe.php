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

$id = anti_injection($id);

$banco = new cPDO();
$oferta = new oferta();
$oferta->set('id', $id);
$sql = $oferta->ListaOferta();
$row_oferta = $banco->query($sql)->fetch();
$id_usuario = $_SESSION['id'];

$usuario = new usuario();
$usuario->set(id, $id_usuario);
$sql = $usuario->ListaUsuario();
$row_pessoa = $banco->query($sql)->fetch();
?>
<div class="content">
    <div class="container_12">
        <div class="grid_9">
            <div class="">
                <form name="bcash" action="https://www.bcash.com.br/checkout/pay/" method="post" >
                    <input name="email_loja" type="hidden" value="anacm.maciel@gmail.com"> 

                    <!-- Dados do Pedido / Produtos -->
                    <input name="produto_codigo_1" type="hidden" value="1001"> 
                    <input name="produto_descricao_1" type="hidden" value="<?php echo $row_oferta['nome']; ?>">
                    <input name="produto_qtde_1" type="hidden" value="1"> 
                    <input name="produto_valor_1" type="hidden" value="<?php echo $row_oferta['valor_liquido']; ?>">

                    <!-- Dados do Comprador -->
                    <input name="email" type="hidden" value="<?php echo $row_pessoa['email']; ?>">
                    <input name="nome" type="hidden" value="<?php echo $row_pessoa['nome']; ?>">
                    <input name="cpf" type="hidden" value="<?php echo $row_pessoa['cpf']; ?>">
                    <input name="telefone" type="hidden" value=""> 
                    <input name="cliente_cnpj" type="hidden" value="">
                    <input name="cliente_razao_social" type="hidden" value="">

                    <!-- Dados de Entrega -->
                    <input name="cep" type="hidden" value="17505000">
                    <input name="endereco" type="hidden" value="Av. Paulista, 1070">
                    <input name="cidade" type="hidden" value="Sao Paulo">
                    <input name="estado" type="hidden" value="SP">

                    <h3><?php echo utf8_encode($row_oferta['nome']); ?></h3>
                    <div class="tempo">Tempo restante</div>
                    <div id="tempoRestante"></div>
                    <img src="<?php echo $caminho; ?>images/page2_img1.jpg" alt="" class="img_inner fleft">
                    <div class="qtd_vendida">Qtd Vendida: <?php echo $row_oferta['qtd_vendida'] ?></div>
                    <div></div>
                    <p class="text1"><?php echo $row_oferta['descricao']; ?></p>
                    <input type="hidden" value='<?php echo $row_oferta['id']; ?>'>
                    <?php
                    //if($row_oferta['qtd_minima']){
                    $sql = "INSERT INTO venda VALUES ('0','" . $row_oferta['id'] . "','" . $id_usuario . "',NOW(),'PENDENTE')";
                    $sqlOferta = "UPDATE oferta SET qtd_vendida='" . ($row_oferta['qtd_vendida'] + 1) . "' where id='" . $row_oferta['id'] . "'";
                    $banco->query($sql);
                    $banco->query($sqlOferta);
                    ?>
                    <input type="image" src=https://www.bcash.com.br/webroot/img/bt_comprar.gif value="Comprar" alt="Comprar" border="0" align="absbottom" >
                    <?php
                    //   }
                    ?>
                </form>
                <div class="clear"></div>
            </div>
        </div>
        <div class="grid_3">
            <h3>Ofertas Ativas</h3>
            <ul class="list1">
                <?php
                $ofertas = new oferta();
                $verificaOferta = new oferta();
                $ofertas->set('start', 0);
                $ofertas->set('limit', 3);
                $sql = $ofertas->ListaOferta();
                $cont = 1;
                foreach ($banco->query($sql) as $row) {
                    $verificaOferta->set('id', $row['id']);
                    $sqlVerifica = $verificaOferta->verificaStatusOferta();
                    //echo $sqlVerifica;
                    $row_oferta = $banco->query($sqlVerifica)->fetch();
                    if ($row_oferta['dias'] > 0 && $row_oferta['status'] == 1) {
                        ?>
                        <li>
                            <div class="count"><?php echo $cont; ?></div>
                            <div class="extra_wrapper">
                                <div class="text1"><a href="<?php echo $caminho; ?>site/ofertaDetalhe/<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></a></div><?php echo $row['descricao']; ?>
                            </div>
                        </li>
                        <?php
                    }
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

    function concluirCompra() {
        alert('concluir compra!');
        $("#formCompra").attr("action", "<?php echo $caminho; ?>comp/");
        $("#formCompra").submit();
    }


</script>