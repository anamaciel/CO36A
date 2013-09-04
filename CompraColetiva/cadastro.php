
<script>
    $(function() {
        //find all form with class jqtransform and apply the plugin
        $(".form").jqTransform();
    });
</script>

<div class="content">
    <div class="container_12">
        <form  class="form" id="form">
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
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Nome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Sobrenome</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Sobrenome inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>CPF</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*CPF inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>RG</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*RG inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Data de Nascimento</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Data inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name" style="width: 345px">
                        <span>Sexo</span>
                        <select name="select">
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
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Logradouro inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Número</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Número inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Complemento</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Complemento inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Bairro</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Bairro inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>CEP</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*CEP inválido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name" style="width: 345px">
                        <span>Estado</span>
                        <select name="estado">
                            <option value="M">-</option>
                        </select>
                    </label>
                    <label class="name" style="width: 345px">
                        <div class="spaceLabel"></div>
                        <span>Cidade</span>
                        <select name="cidade">
                            <option value="M">-</option>
                        </select>
                        <div class="spaceLabel"></div>
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
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Este não é um endereço de email válido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Senha</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Senha inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <label class="name">
                        <span>Confirmar Senha</span>
                        <input type="text" value="">
                        <br class="clear">
                        <span class="error error-empty">*Senhas não conferem.</span><span class="empty error-empty">*Campo Requerido.</span> 
                        <div class="spaceLabel"></div>
                    </label>
                    <div class="clear"></div>
                    <div class="btns" style="margin: 20px 11px;">
                        <a href="<?php echo $caminho; ?>site/cadastro/" class="btn">Criar meu Cadastro</a>
                        <div class="clear"></div>
                    </div>
                </fieldset>
            </div>
        </form>
        <div class="clear"></div>
    </div>
</div>
