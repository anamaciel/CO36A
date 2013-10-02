<script>
    $(document).ready(function() {
        $('#bEnviar').click(function() {
            var nome = $("#oferta").val();
            var descricao = $("#descricao").val();
            var data_inicio = $("#data_inicio").val();
            var data_fim = $("#data_fim").val();
            var qtd_minima = $("#qtd_minima").val();
            var valor_real = $("#valor_real").val();
            var valor_liquido = $("#valor_liquido").val();
            $('#form').fadeTo("slow", 0.3);
            $.post("<?php echo $caminho; ?>cadOferta/", {
                nome: nome,
                descricao: descricao,
                data_inicio: data_inicio,
                data_fim: data_fim,
                qtd_minima: qtd_minima,
                valor_real: valor_real,
                valor_liquido: valor_liquido, },
                    function(retorno) {
                        $('#respostaCadastro').html(retorno).fadeIn();
                        $('#form').fadeTo("slow", 2);
                    });
        });
    });
</script>
<?php
if ($_SESSION['id'] == '') {

    echo "<script language=\"javascript\">location.href=\"" . $caminho . "site/login\"</script>";
} else {
    if (!isset($_SESSION)) {
        session_start();
    }
    require_once("class/funcoes.php");
require_once("class/pdo.class.php");
$banco = new cPDO();
    
    $id_usuario = $_SESSION['id'];
    ?>

    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_12">
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
                </div>
                <div class="grid_3">
                    <fieldset>
                        <label class="name">
                            <span>Data Início</span>
                            <input type="text" value="" name="data_inicio" id="data_inicio">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="grid_3">
                    <fieldset>
                        <label class="name">
                            <span>Data Fim</span>
                            <input type="text" value="" name="data_fim" id="data_fim">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="grid_2">
                    <fieldset>
                        <label class="name">
                            <span>Qtd Mínima</span>
                            <input type="text" value="" name="qtd_minima" id="qtd_minima">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="grid_2">
                    <fieldset>
                        <label class="name">
                            <span>Valor Real</span>
                            <input type="text" value="" name="valor_real" id="valor_real">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="grid_2">
                    <fieldset>
                        <label class="name">
                            <span>Valor Liquido</span>
                            <input type="text" value="" name="valor_liquido" id="valor_liquido">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>

                <div class="clear"></div>

                <div id="respostaCadastro"></div>

                <div class="clear"></div>

                <div class="btns">
                    
                    <a class="btn" id="bEnviar" name="bEnviar">Enviar</a>
                    <div class="none"></div>

                    <div class="clear"></div>
                </div>

            </form>
        </div>
        <div class="clear"></div>
        <div class="grid_12">
            <h3>MINHAS OFERTAS</h3>
            <fieldset>
                <ul>
                    <?php
                    $sql = "SELECT o.* FROM oferta o WHERE status='1' AND o.usuario_id = " . $id_usuario;
                    //echo $sql;
                    foreach ($banco->query($sql) as $row) {
                        ?>
                        <li class="link-li" onclick="location.href = '<?php echo $caminho; ?>site/ofertaDetalhe/<?php echo $row['id']; ?>'"><?php echo $row['nome']; ?>
                        </li>
                        <a class="btn" id="bEnviar" name="bEnviarFoto" onclick="location.href = '<?php echo $caminho; ?>site/uploadFoto/<?php echo $row['id']; ?>'">Enviar Foto</a>
                        <?php
                    }
                    ?>
                </ul>
            </fieldset>
        </div>
        <div class="clear"></div>
    </div>    
    <?php
}
?>
