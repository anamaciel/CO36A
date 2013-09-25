<?php
if ($_SESSION['id'] == '') {

    echo "<script language=\"javascript\">location.href=\"" . $caminho . "site/login\"</script>";
} else {
    ?>

    <div class="content">
        <div class="container_12">
            <div class="grid_12">
                <form id="form">
                    <h3>CADASTRAR OFERTA</h3>
                    <fieldset>
                        <label class="name">
                            <span>Oferta</span>
                            <input type="text" value="" name="oferta" id="oferta">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Descrição</span>
                            <input type="text" value="" name="descricao" id="descricao">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>

                    <div class="clear"></div>

                    <div id="respostaCadastro"></div>

                    <div class="clear"></div>

                    <div class="btns">
                        <a data-type="reset" id="reset" class="btn">Limpar</a>
                        <div class="none"></div>
                        <a class="btn" id="bEnviar" name="bEnviar">Enviar</a>
                        <div class="clear"></div>
                    </div>

                </form>
            </div>
            <div class="clear"></div>
            <form id="form">
                <div class="grid_12">
                    <h3>MINHAS OFERTAS</h3>
                    <fieldset>
                        <ul>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/minha_oferta_detalhe/01'">Minha Oferta 01</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/minha_oferta_detalhe/02'">Minha Oferta 02</li>
                            <li class="link-li" onclick="location.href='<?php echo $caminho; ?>site/minha_oferta_detalhe/03'">Minha Oferta 03</li>
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
