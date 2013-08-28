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
                        <input type="text" value="Email">
                        <br class="clear">
                        <span class="error error-empty">*Este não é um endereço de email válido.</span><span class="empty error-empty">*Campo Requerido.</span> 
                    </label>
                    <label class="name">
                        <input type="text" value="Senha">
                        <br class="clear">
                        <span class="error error-empty">*Senha inválida.</span><span class="empty error-empty">*Campo Requerido.</span> 
                    </label>
                    <div class="clear"></div>
                    <ul class="list2 l1">
                        <li><a href="#">Esqueci minha senha</a></li>
                    </ul>
                    <div class="clear"></div>
                    <div class="btns"><a data-type="reset" class="btn">Limpar</a><div class="none"></div><a data-type="submit" class="btn">Enviar</a>
                        <div class="clear"></div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
