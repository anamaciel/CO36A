<?php
if ($_SESSION['id'] == '') {

    echo "<script language=\"javascript\">location.href=\"" . $caminho . "site/login\"</script>";
} else {
    ?>

    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_12">
                    <fieldset>
                        <h3>MINHAS COMPRAS</h3>
                        <ul>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/pedido/01'">Pedido 01</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/pedido/02'">Pedido 02</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/pedido/03'">Pedido 03</li>
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
