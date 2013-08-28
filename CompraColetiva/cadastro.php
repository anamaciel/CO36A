<?php
if (!isset($_SESSION)) {
    session_start();
}

$idUser = decode5t($_SESSION['id']);
if ($idUser == '') {
    $id = '';
    $titulo = "Cadastre-se";
} else {
    $titulo = "Minha Conta - Dados Pessoais";
}
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>estilos/estiloCadastro.css" />
<script type="text/javascript" src="<?php echo $caminho; ?>js/jquery.maskedinput-1.1.4.js" ></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("select[name=uf]").change(function(){
            $("select[name=cidade]").html('<option value="0">Carregando...</option>');
    		
            $.post("/city/", {
                uf:$(this).val()
            },
            function(valor){
                $("select[name=cidade]").html(valor);
            }
        );
        });
        $(function(){  
            $("#fone").mask("(99)9999-9999");  
            $("#nascimento").mask("99/99/9999");  
            $("#cpf").mask("999.999.999-99");  
        }); 
        $('#bEnviar').click(function(){
            var nome       = $("#nome").val();
            var email      = $("#email").val();
            var cpf        = $("#cpf").val();
            var rg         = $("#rg").val();
            var nascimento = $("#nascimento").val();
            var sexo       = $("#sexo").val();
            var fone       = $("#fone").val();
            var confirmar  = $("#confirmar").val();
            var userPass   = $("#userPass").val();
            var user       = $("#user").val();
                
            if (nome!='' && email!='' && cpf!='' && nascimento!='' && user != '' && userPass!='' && confirmar!='') {
                $('#frmCadastro').fadeTo("slow", 0.3);					
                $.post("<?php echo $caminho; ?>cadastros/",{nome:nome, email:email, cpf:cpf, rg:rg, 
                    nascimento:nascimento, sexo:sexo, fone:fone, confirmar:confirmar, userPass:userPass, user:user},
                function(retorno){
                    $('#respostaCadastro').html(retorno).fadeIn();
                    $('#frmCadastro').fadeTo("slow", 2);	
                });
            } else{
                jAlert("Preenha os campos obrigatorios", "Atenção!");
                formIsEmpty('nome'), 
                formIsEmpty('email'), 
                formIsEmpty('cpf'), 
                formIsEmpty('nascimento'), 
                formIsEmpty('confirmar'), 
                formIsEmpty('userPass'), 
                formIsEmpty('user');
            }
            return false;
        });
    });
                
</script>
<?php
require_once("class/mysql.class.php");
require_once("class/estado.class.php");
require_once("class/cidade.class.php");
require_once("class/cliente.class.php");

if ($idUser != '') {
    $banco = new database();
    $banco->connect();

    $cliente = new cliente();
    $cliente->set(id_pessoa, anti_injection($idUser));

    $sql = $cliente->ListaCliente();
    $banco->sqlQuery($sql);

    $row = $banco->fetch_object();
    ?>
    <div id="menuDown">
        <div class="itemMenu"><?php echo $titulo; ?></div>
    </div>

    <fieldset class="listaField bordaArredondada_10">
        <legend><img src="<?php echo $caminho; ?>images/icones/user.png" align="absmiddle" /> Dados Pessoais</legend>
        <?php
        $banco = new database();
        $banco->connect();

        $cliente = new cliente();
        $cliente->set(id_pessoa, anti_injection($idUser));

        $sql = $cliente->ListaCliente();
        $banco->sqlQuery($sql);

        $row = $banco->fetch_object();

        echo "<ul>";
        echo "<li>Nome: " . $row->nome . "</li>";
        echo "<li>CPF: " . $row->cpf_cnpj . "</li>";
        echo "<li>RG: " . $row->rg_ie . "</li>";
        echo "<li>Nascimento: " . $row->dt_aniversarioF . "</li>";
        if ($row->id_sexo == 2) {
            echo "<li>Sexo: Feminino </li>";
        } else {
            echo "<li>Sexo: masculino </li>";
        }
        echo "<li>Email: " . $row->email . "</li>";
        echo "<li>Fone: " . $row->telefone . "</li>";
        echo "</ul>";
        $banco->close();
        ?>
    </fieldset>
    <?php
} else {
    ?>
    <div class="paginaCadastro">
        <div id="menuDown">
            <div class="itemMenu"><?php echo $titulo; ?></div>
        </div>
        <form name="frmCadastro" id="frmCadastro" class="cadastro" method="post" action="#" >
            <fieldset class="listaField bordaArredondada_10">
                <legend><img src="<?php echo $caminho; ?>images/icones/user.png" align="absmiddle" /> Dados Pessoais</legend>
                <div>
                    <label>Nome:</label>
                    <input type="text" name="nome" id="nome" class="nome" maxlength="200"  onBlur="formIsEmpty(this);"/>
                </div>
                <div style="width: 100%; margin-top: 10px;"></div>
                <div>
                    <label>CPF:</label>
                    <input type="text" name="cpf" class="cpf" maxlength="200" id="cpf" onBlur="javascript:validaCPF(this), formIsEmpty(this);" /> 
                    <label class="lbRg">RG:</label>
                    <input type="text" name="rg" class="rg" id="rg" maxlength="200" onBlur="formIsEmpty(this);" />
                    <label class="lbNascimento">Nascimento:</label>
                    <input type="text" name="nascimento" maxlength="200" class="nascimento" id="nascimento" onblur="validaData(this,this.value);" />
                    <label class="lbSexo">Sexo:</label>
                    <select name="sexo" id="sexo" style="width: 55px;">
                        <option value="1">M</option>
                        <option value="2">F</option>
                    </select>
                </div>
                <div style="width: 100%; margin-top: 10px;"></div>
                <div>
                    <label>E-Mail:</label>
                    <input type="text" name="Email" class="email" id="email" maxlength="200" onBlur="ValidaEmail(this), formIsEmpty(this);" />
                </div>
                <div>
                    <label class="lbCep">Fone:</label>
                    <input type="text" name="fone" class="fone" maxlength="200" id="fone" onBlur="formIsEmpty(this);" /> 
                </div>
            </fieldset>
            <div class="clear"></div>

            <?php if ($id_up == '') { ?>
                <fieldset class="listaField bordaArredondada_10">
                    <legend><img src="<?php echo $caminho; ?>images/icones/pas.png" align="absmiddle" /> Dados de Login</legend>
                    <div style="width: 100%; margin-top: 20px;"></div>
                    <div style="float: left;">
                        <label>Login:</label>
                        <input type="text" name="user" class="fone" maxlength="200" id="user" onBlur="formIsEmpty(this);" /> 
                        <label style="width: 70px;">Senha:</label>
                        <input type="password" name="userPass" class="senha" id="userPass" maxlength="200" onBlur="formIsEmpty(this);" />
                    </div>
                    <div style="float: left; width: 276px; margin-left: 10px;">
                        <label class="labelLogin">Confirmar Senha:</label>
                        <input type="password" name="confirmar" maxlength="200" class="senha" id="confirmar" onBlur="formIsEmpty(this);" />
z                    </div>
                <?php } ?>
                <div class="clear"></div><!--clear-->

                <div style="width: 100%; margin-bottom: 20px;"></div>

                <div class="clear"></div><!--clear-->
                <div style="width: 100%;"></div><!--clear-->
                <div id="respostaCadastro" class="respostaCadastro"></div>
            </fieldset>
            <input id="bLimpar" name="bLimpar" type="reset" value="Limpar" border="0"/>
            <input id="bEnviar" name="bEnviar" type="button" value="Enviar" border="0"/>
        </form>
    </div>
<?php } ?>