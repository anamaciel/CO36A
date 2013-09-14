<script>
    $(document).ready(function() {
        $('#bEnviar').click(function() {
            var email = $("#email").val();
            var senha = $("#senha").val();

            if (true) {
                $('#form').fadeTo("slow", 0.3);
                $.post("<?php echo $caminho; ?>logar/", {
                    email: email,
                    senha: senha
                },
                function(retorno) {
                    $('#respostaCadastro').html(retorno).fadeIn();
                    $('#form').fadeTo("slow", 2);
                });
            } else {
                $('#respostaCadastro').html("Preenha os campos obrigatorios").fadeIn();
            }
            return false;
        });

        $('#reset').click(function() {
            $("#email").val('');
            $("#senha").val('');
        });

    });

    $(function() {
        //find all form with class jqtransform and apply the plugin
        $(".form").jqTransform();
    });
</script>


<div class="content">
    <div class="container_12">
        <div class="grid_5">
            <h3>AINDA NÃO TENHO CADASTRO</h3>
            <div class="text3">Fazendo seu cadastro no NOME_DO_SITE você garante a praticidade de poder adquirir produtos incrives com apenas alguns cliques.</div><br>
            <form>
                <fieldset>
                    <div class="btns">
                        <div class="btn_cad">
                            <a href="<?php echo $caminho; ?>site/cadastro/" class="btn">Criar meu Cadastro</a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="grid_1 space"></div>
        <div class="grid_5">
            <h3>JÁ SOU CADASTRADO</h3>
            <div class="text3">Se você já é cadastrado, por favor faça o login.</div><br>
            <form id="form">
                <div class="success_wrapper">
                    <div class="success">Contato enviado com sucesso<br>
                        <strong>Entraremos em contato em breve</strong> 
                    </div>
                </div>
                <fieldset>
                    <label class="email">
                        <span>Email</span>
                        <input type="text" value="" id="email">
                        <br class="clear">
                        <span class="error error-empty">*Este não é um endereço de email válido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Senha</span>
                        <input type="password" value="" id="senha">
                        <br class="clear">
                        <span class="error error-empty">*Senha inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <div class="clear"></div>
                    <ul class="list2 l1">
                        <li><a href="#">Esqueci minha senha</a></li>
                    </ul>

                    <div class="clear"></div>

                    <div id="respostaCadastro"></div>

                    <div class="clear"></div>

                    <div class="btns">
                        <a data-type="reset" id="reset" class="btn">Limpar</a>
                        <div class="none"></div>
                        <a class="btn" id="bEnviar" name="bEnviar">Enviar</a>
                        <div class="clear"></div>
                    </div>


                </fieldset>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
