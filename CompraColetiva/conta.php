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
                        <h3>MINHA CONTA</h3>
                        <ul>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/meus_dados'">Meus Dados</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/minhas_compras'">Minhas Compras</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/minhas_ofertas'">Minhas Ofertas</li>
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
