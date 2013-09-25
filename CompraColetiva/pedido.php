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
                        <h3>DETALHES DO PEDIDO</h3>
                        <ul>
                            <li>Oferta</li>
                            <li>Data</li>
                            <li>Valor</li>
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
