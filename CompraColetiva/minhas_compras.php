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
    $id_usuario = $_SESSION['id'];
    $banco = new cPDO();

    $sql = "SELECT o.*, v.id as id_venda FROM oferta o, venda v WHERE v.oferta_id = o.id AND v.usuario_id = " . $id_usuario;
    ?>

    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_12">
                    <fieldset>
                        <h3>MINHAS COMPRAS</h3>
                        <ul>
                            <?php
                            foreach ($banco->query($sql) as $row) {
                                ?>
                                <li class="link-li" onclick="location.href = '<?php echo $caminho; ?>site/pedido/<?php echo $row['id_venda']; ?>'"><?php echo $row['nome']; ?></li>
                                <?php
                            }
                            ?>
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
