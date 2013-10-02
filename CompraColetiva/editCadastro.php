<script>
    $(document).ready(function() {
        $("select[name=uf]").change(function() {
            $("select[name=cidade]").html('<option value="0">Carregando...</option>');

            $.post("<?php echo $caminho; ?>city/", {
                uf: $(this).val()
            },
            function(valor) {
                $("select[name=cidade]").html(valor);
            }
            );
        });
        $(function() {
            $("#fone").mask("(99)9999-9999");
            $("#nascimento").mask("99/99/9999");
            $("#cpf").mask("999.999.999-99");
        });

        $('#reset').click(function() {
            $("#nome").val('');
            $("#sobrenome").val('');
            $("#cpf").val('');
            $("#rg").val('');
            $("#nascimento").val('');
            $("#fone").val('');
            $("#sexo").val('');
            $("#logradouro").val('');
            $("#numero").val('');
            $("#complemento").val('');
            $("#bairro").val('');
            $("#cep").val('');
            $("#cidade").val('');
            $("#uf").val('');
            $("#email").val('');
            $("#senha").val('');
            $("#confirma").val('');
        });

        $('#bEnviar').click(function() {
            var id = $("#id").val();
            var nome = $("#nome").val();
            var sobrenome = $("#sobrenome").val();
            var cpf = $("#cpf").val();
            var rg = $("#rg").val();
            var nascimento = $("#nascimento").val();
            var fone = $("#fone").val();
            var sexo = $("#sexo").val();
            var logradouro = $("#logradouro").val();
            var numero = $("#numero").val();
            var complemento = $("#complemento").val();
            var bairro = $("#bairro").val();
            var cep = $("#cep").val();
            var cidade = $("#cidade").val();
            var uf = $("#uf").val();
            var email = $("#email").val();
            var senha = $("#senha").val();
            var confirma = $("#confirma").val();

            if (nome != '' && sobrenome != '' && email != '') {
                $('#form').fadeTo("slow", 0.3);
                $.post("<?php echo $caminho; ?>edit/", {
                    id: id,
                    nome: nome,
                    sobrenome: sobrenome,
                    cpf: cpf,
                    rg: rg,
                    nascimento: nascimento,
                    fone: fone,
                    sexo: sexo,
                    logradouro: logradouro,
                    complemento: complemento,
                    numero: numero,
                    bairro: bairro,
                    cep: cep,
                    email: email,
                    confirma: confirma,
                    senha: senha},
                function(retorno) {
                    $('#respostaCadastro').html(retorno).fadeIn();
                    $('#form').fadeTo("slow", 2);
                });
            } else {
                alert('Nada');
                $('#respostaCadastro').html("Preenha os campos obrigatorios").fadeIn();
            }
            return false;
        });
    });

    $(function() {
        //find all form with class jqtransform and apply the plugin
        $(".form").jqTransform();
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
    require_once("class/oferta.class.php");
    require_once("class/usuario.class.php");
    $id = anti_injection($id);
    $banco = new cPDO();
    $usuario = new usuario();
    $usuario->set('id', $id);
    $sql = $usuario->ListaUsuario();
    //echo $sql;
    $row_pessoa = $banco->query($sql)->fetch();
    ?>

    <div class="content">
        <div class="container_12">
            <form id="form">
                <div class="grid_4">
                    <h3>DADOS PESSOAIS</h3>
                    <div class="success_wrapper">
                        <div class="success">Cadastro realizado com sucesso<br>
                            <strong>Aproveite as ofertas do site</strong> 
                        </div>
                    </div>
                    <fieldset>
                        <input type="hidden" value="<?php echo $id; ?>" name="id" id="id">
                        <label class="name">
                            <span>Nome</span>
                            <input type="text" value="<?php echo $row_pessoa['nome']; ?>" name="nome" id="nome">
                            <br class="clear">
                            <span class="error error-empty">*Nome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Sobrenome</span>
                            <input type="text" value="<?php echo $row_pessoa['sobrenome']; ?>" name="sobrenome" id="sobrenome">
                            <br class="clear">
                            <span class="error error-empty">*Sobrenome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>CPF</span>
                            <input type="text" value="<?php echo $row_pessoa['cpf']; ?>" name="cpf" id="cpf">
                            <br class="clear">
                            <span class="error error-empty">*CPF inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>RG</span>
                            <input type="text" value="<?php echo $row_pessoa['rg']; ?>" name="rg" id="rg">
                            <br class="clear">
                            <span class="error error-empty">*RG inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Data de Nascimento</span>
                            <input type="text" value="<?php echo convdata($row_pessoa['nascimento']); ?>" name="nascimento" id="nascimento">
                            <br class="clear">
                            <span class="error error-empty">*Data inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Sexo</span>
                            <select name="sexo" id="sexo" class="select">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                            <div class="spaceLabel"></div>
                        </label>
                </div>

                <div class="grid_4">
                    <h3>DADOS DE LOGIN</h3>
                    <div class="success_wrapper">
                        <div class="success">Contato enviado com sucesso<br>
                            <strong>Entraremos em contato em breve</strong> 
                        </div>
                    </div>
                    <fieldset>
                        <label class="email">
                            <span>Email</span>
                            <input type="text" value="<?php echo $row_pessoa['login']; ?>" name="email" id="email">
                            <br class="clear">
                            <span class="error error-empty">*Este não é um endereço de email válido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Senha</span>
                            <input type="password" value="<?php echo $row_pessoa['senha']; ?>" name="senha" id="senha">
                            <br class="clear">
                            <span class="error error-empty">*Senha inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <label class="name">
                            <span>Confirmar Senha</span>
                            <input type="password" value="<?php echo $row_pessoa['senha']; ?>" name="confirma" id="confirma">
                            <br class="clear">
                            <span class="error error-empty">*Senhas não conferem.</span><span class="empty error-empty">*Campo Requerido.</span> 
                            <div class="spaceLabel"></div>
                        </label>
                        <div class="clear"></div>
                        <div class="btns">
                            <a data-type="reset" id="reset" class="btn">Limpar</a>
                            <div class="none"></div>
                            <a class="btn" id="bEnviar" name="bEnviar">Enviar</a>
                            <div class="clear"></div>
                        </div>
                    </fieldset>
                    <div class="clear"></div>
                    <div id="respostaCadastro"></div>
                </div>
            </form>
            <div class="clear"></div>
        </div>
    </div>
    <?php
}
?>