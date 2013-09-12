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
                    email: email,
                    confirma: confirma, 
                    senha: senha},
                function(retorno) {
                });
            return false;
        });
    });

</script>

<div class="content">
    <form id="form111">
        <h3>DADOS PESSOAIS</h3>
        <label>
            Nome
            <input type="text" value="" name="nome" id="nome">
        </label>
        <label>
            Sobrenome
            <input type="text" value="" name="sobrenome" id="sobrenome">
        </label>
        <label>
            CPF
            <input type="text" value="" name="cpf" id="cpf">
        </label>
        <label>
            RG
            <input type="text" value="" name="rg" id="rg">
        </label>
        <label>
            Data de Nascimento
            <input type="text" value="" name="nascimento" id="nascimento">
        </label>
        <label>
            Telefone
            <input type="text" value="" name="fone" id="fone">
        </label>
        <label style="width: 345px">
            Sexo
            <select name="sexo" id="sexo">
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
            </select>
        </label>

        <h3>ENDEREÇO</h3>
        <label>
            Logradouro
            <input type="text" value="" name="logradouro" id="logradouro">
        </label>
        <label>
            Número
            <input type="text" value="" name="numero" id="numero">
        </label>
        <label>
            Complemento
            <input type="text" value="" name="complemento" id="complemento">
        </label>
        <label>
            Bairro
            <input type="text" value="" name="bairro" id="bairro">
        </label>
        <label>
            CEP
            <input type="text" value="" name="cep" id="cep">
        </label>
        <label style="width: 345px">
        </label>
        <h3>DADOS DE LOGIN</h3>
        <label>
            Email
            <input type="text" value="" name="email" id="email">
        </label>
        <label>
            Senha
            <input type="password" value="" name="senha" id="senha">
        </label>
        <label>
            Confirmar Senha
            <input type="password" value="" name="confirma" id="confirma">
        </label>
        <div class="clear"></div>
        <div class="btns" style="margin: 20px 11px;">
            <!--<a href="#" id="bEnviar" class="btn">Criar meu Cadastro</a>-->

            <div class="clear"></div>
        </div>
        <div id="respostaCadastro"></div>

        <div class="clear"></div>
        Estado
        <select name="uf" id="uf">
            <option value="">-</option>
            <option value="18">PR</option>
        </select>
        Cidade
        <select name="cidade" id="cidade">
            <option value="M">-</option>
        </select>

        <input id="bEnviar" name="bEnviar" type="button" value="Enviar" border="0"/>
    </form>
</div>
