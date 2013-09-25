<?php
if ($_SESSION['id'] == '') {

    echo "<script language=\"javascript\">location.href=\"" . $caminho . "site/login\"</script>";
} else {
    

if (!isset($_SESSION)) {
    session_start();
}

require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("class/oferta.class.php");
require_once("class/usuario.class.php");

$id = anti_injection($id);

$banco = new cPDO();

$sql = "SELECT v.*,o.* FROM oferta o, venda v WHERE v.oferta_id = o.id AND v.id =".$id;

$row = $banco->query($sql)->fetch();
?>
    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_12">
                    <fieldset>
                        <h3>DETALHES DO PEDIDO</h3>
                        <ul>
                            <li>Oferta: <?php echo $row['nome']; ?></li>
                            <li>Valor: <?php echo $row['valor_liquido']; ?></li>
                            <li>Status: <?php echo $row['status']; ?></li>
                        </ul>
                    </fieldset>
                </div>
            </form>
            <div class="clear"></div>
        </div>
    </div>    
    <?php
}
?>
