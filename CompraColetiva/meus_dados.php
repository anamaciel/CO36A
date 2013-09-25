<?php
if ($_SESSION['id'] == '') {

    echo "<script language=\"javascript\">location.href=\"" . $caminho . "site/login\"</script>";
} else {
    ?>
    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_4">
                    <fieldset>
                        <h3>DADOS PESSOAIS</h3>
                        <ul>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                        </ul>
                    </fieldset>
                </div>
                <div class="grid_4">
                    <fieldset>
                        <h3>ENDEREÇO</h3>
                        <ul>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                            <li>Nome</li>
                        </ul>
                    </fieldset>
                </div>
                <div class="grid_4">
                    <fieldset>
                        <h3>DADOS DE LOGIN</h3>
                        <ul>
                            <li>Email</li>
                        </ul>
                    </fieldset>
                </div>
                <div class="clear"></div>
                <div class="btns">
                    <div class="btn_cad">
                        <a href="<?php echo $caminho; ?>site/cadastro/" class="btn">Alterar Dados</a>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
            <div class="clear"></div>
        </div>
    </div>

    <?php
}
?>