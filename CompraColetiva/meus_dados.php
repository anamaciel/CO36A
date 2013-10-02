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
    $usuario = new usuario();
    $usuario->set(id, $id_usuario);
    $sql = $usuario->ListaUsuario();
    $row_pessoa = $banco->query($sql)->fetch();
    ?>
    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_6">
                    <fieldset>
                        <h3>DADOS PESSOAIS</h3>
                        <ul>
                            <li>Nome: <?php echo $row_pessoa['nome']; ?></li>
                            <li>Sobrenome: <?php echo $row_pessoa['Sobrenome']; ?></li>
                            <li>Sexo: <?php echo $row_pessoa['sexo']; ?></li>
                            <li>Nascimento: <?php echo convdata($row_pessoa['nascimento']); ?></li>
                            <li>Login: <?php echo $row_pessoa['login']; ?></li>
                        </ul>
                    </fieldset>
                </div>
<!--                <div class="grid_6">
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
                </div>-->
                <div class="clear"></div>
                <div class="btns">
                    <div class="btn_cad">
                        <a href="<?php echo $caminho; ?>site/editCadastro/<?php echo $row_pessoa['id']; ?>" class="btn">Alterar Dados</a>
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