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

        $('#bEnviar').click(function() {
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
                $.post("<?php echo $caminho; ?>cad/", {
                    nome: nome, 
                    sobrenome: sobrenome,
                    cpf: cpf, 
                    rg: rg, 
                    nascimento: nascimento, 
                    fone: fone, 
                    sexo: sexo,
                    logradouro:logradouro,
                    complemento: complemento,
                    numero:numero,
                    bairro:bairro,
                    cep:cep,
                    cidade:cidade,
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
                    <label class="name">
                        <span>Nome</span>
                        <input type="text" value="" name="nome" id="nome">
                        <br class="clear">
                        <span class="error error-empty">*Nome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Sobrenome</span>
                        <input type="text" value="" name="sobrenome" id="sobrenome">
                        <br class="clear">
                        <span class="error error-empty">*Sobrenome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>CPF</span>
                        <input type="text" value="" name="cpf" id="cpf">
                        <br class="clear">
                        <span class="error error-empty">*CPF inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>RG</span>
                        <input type="text" value="" name="rg" id="rg">
                        <br class="clear">
                        <span class="error error-empty">*RG inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Data de Nascimento</span>
                        <input type="text" value="" name="nascimento" id="nascimento">
                        <br class="clear">
                        <span class="error error-empty">*Data inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Telefone</span>
                        <input type="text" value="" name="fone" id="fone">
                        <br class="clear">
                        <span class="error error-empty">*Telefone inválido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name" style="width: 345px">
                        <span>Sexo</span>
                        <select name="sexo" id="sexo">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                        <div class="spaceLabel"></div>
                    </label>
            </div>
            <div class="grid_4">
                <h3>ENDEREÇO</h3>
                <fieldset>
                    <label class="name">
                        <span>Logradouro</span>
                        <input type="text" value="" name="logradouro" id="logradouro">
                        <br class="clear">
                        <span class="error error-empty">*Logradouro inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Número</span>
                        <input type="text" value="" name="numero" id="numero">
                        <br class="clear">
                        <span class="error error-empty">*Número inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Complemento</span>
                        <input type="text" value="" name="complemento" id="complemento">
                        <br class="clear">
                        <span class="error error-empty">*Complemento inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Bairro</span>
                        <input type="text" value="" name="bairro" id="bairro">
                        <br class="clear">
                        <span class="error error-empty">*Bairro inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>CEP</span>
                        <input type="text" value="" name="cep" id="cep">
                        <br class="clear">
                        <span class="error error-empty">*CEP inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>


                    <label class="name" style="width: 345px">


                    </label>
                </fieldset>

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
                        <input type="text" value="" name="email" id="email">
                        <br class="clear">
                        <span class="error error-empty">*Este não é um endereço de email válido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Senha</span>
                        <input type="password" value="" name="senha" id="senha">
                        <br class="clear">
                        <span class="error error-empty">*Senha inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Confirmar Senha</span>
                        <input type="password" value="" name="confirma" id="confirma">
                        <br class="clear">
                        <span class="error error-empty">*Senhas não conferem.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <div class="clear"></div>
                    <div class="btns" style="margin: 20px 11px;">
                        <!--<a href="#" id="bEnviar" class="btn">Criar meu Cadastro</a>-->
                        
                        <div class="clear"></div>
                    </div>
                </fieldset>
            </div>
            <div id="respostaCadastro"></div>
        </form>
        <div class="clear"></div>
    </div>
    <span>Estado</span>
    <select name="uf" id="uf">
        <option value="">-</option>
        <option value="18">PR</option>
    </select>
    <span>Cidade</span>
    <select name="cidade" id="cidade">
        <option value="M">-</option>
    </select>
    
    <input id="bEnviar" name="bEnviar" type="button" value="Enviar" border="0"/>
</div>