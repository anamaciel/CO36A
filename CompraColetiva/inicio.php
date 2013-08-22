<?php
if (!isset($_SESSION)) {
    session_start();
}
$vlM = 0;
//error_reporting(E_ALL);
//ini_set('display_errors','On');
require_once("class/funcoes.php");
require_once("class/documento.class.php");
require_once("class/promocao.class.php");
require_once("class/midia.class.php");
require_once("class/pdo.class.php");
require_once("class/produtos.class.php");
require_once("caminho.php");

$atual = ($_GET['pg'] != '') ? $_GET['pg'] : 'destaques';
$permissao = array('capa', 'bairros', 'noticias', 'noticia', 'fotosp', 'videos', 'opartido', 'colaboracoes', 'contato', 'prioridades', 'noticias_lista', 'psdbcm', 'jovem', 'mulher', 'psdb', 'colaboracoes', 'pesquisar', 'fotosv', 'cadastro', 'conta', 'endereco', 'senha', 'produto', 'loja', 'carrinho_add', 'enviarsenha', 'carrinho_lista', 'carrinho_excluir', 'carrinho_update', 'inicio', 'leiloes', 'leilao', 'comprar', 'comofunciona', 'perguntas', 'finalizados', 'carrinho_compra', 'meusarremates', 'meus_arremates_detalhado', 'quemsomos', 'meus_lances', 'minhascompras', 'minhascomprasdetalhado', 'departamentos', 'carregaProdutos', 'destaques');
$pasta = 'internas';
if (substr_count($atual, '/') > 0) {
    $atual = explode('/', $atual);
    $pagina = (!file_exists($caminho . $pasta . "/" . $atual[0] . '.php') && in_array($atual[0], $permissao)) ? $atual[0] : 'erro';
    $id = anti_injection($atual[1]);
    $id2 = anti_injection($atual[2]);
} else {
    $pagina = (!file_exists($caminho . $pasta . "/" . $atual . '.php') && in_array($atual, $permissao)) ? $atual : 'erro';
    $id = 0;
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Fan&aacute;ticos por Compras</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="cache-control" content="public" />
        <link rel="shortcut icon" href="<?php echo $caminho; ?>images/favicon/favicon.png">

        <?php
        if (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml")) {
            header("Content-Type: application/xhtml+xml; charset=UTF-8");
            echo('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">');
        } else {
            header("Content-Type: text/html; charset=UTF-8");
            echo ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
        }
        ?>
        <meta name="description" content="Fanáticos por Compras" />
        <meta name="keywords" content="Fanaticos, Fanáticos, Compras, SexShop, Games, Informatica, Informática, Carrinho, Loja, Virtual" />

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>estilos/reset.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>estilos/estiloIndex.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/pirobox/css_pirobox/style_5/style.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/prettyPhoto/prettyPhoto.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/twitter/jquery.twitter.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/jquery.alerts.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/jcarousel/skins/tango/skin.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $caminho; ?>js/jcarousel/skins/tango/skin_1.css" />

        <!-- JS -->
        <script type="text/javascript" src="<?php echo $caminho; ?>js/jquery-1.7.min.js"></script>
        <script async defer type="text/javascript" src="http://localhost:80/socket.io/socket.io.js"></script> 
        <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/pirobox/js/pirobox_extended_feb_2011.js"></script>
        <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/prettyPhoto/jquery.prettyPhoto.js"></script>
        <script type="text/javascript" src="<?php echo $caminho; ?>js/funcoes.js"></script>
        <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/twitter/jquery.twitter.js" type="text/javascript"></script>
        <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/jcarousellite_1.0.1.js" ></script>
        <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/jcarousel/jquery.jcarousel.min.js"></script>
        <script type='text/javascript'>
            function add_carrinho(a){$.post("<?php echo $caminho; ?>carrinho_add/",{id:a},function(){window.location="<?php echo $caminho; ?>site/carrinho_lista/"})};
        </script>
        <script async defer type='text/javascript'>
            function OnEnter(a,b){13==(a.keyCode?a.keyCode:a.charCode?a.charCode:a.which?a.which:void 0)&&pesquisar(b)}function pesquisar(a){a=document.getElementById(a).value;""!=a&&$.post("<?php echo $caminho; ?>pesquisa/",{pg:"<?php echo $caminho; ?>site/pesquisar/"+a},function(a){__url(a)})}
            function validaLogin(a,b){""==a.val()?(jAlert("Informe o login!"),a.focus()):""==b.val()?(jAlert("Informe a senha!"),b.focus()):$.post("<?php echo $caminho; ?>log/",{login:a.val(),senha:b.val()},function(c){1==c?$.post("<?php echo $caminho; ?>logar/",{login:a.val(),senha:b.val()},function(a){$("#retorno").show();$("#retorno").html(a)}):jAlert("Login ou Senha incorretos!")})}
            function OnEnterLogin(a){13==(a.keyCode?a.keyCode:a.charCode?a.charCode:a.which?a.which:void 0)&&validaLogin($("#log"),$("#pwd"))};
            function lances(a,b){$.post("/lance/",{id:a,ids:b},function(a){0<$("#qtdLances").text()?0==a&&jAlert("Leil\u00e3o Encerrado!"):jAlert("Voc\u00ea est\u00e1\u00a1 sem lances! Adquira um novo pacote.")})}function hasClass(a,b){return a.className.match(RegExp("(\\s|^)"+b+"(\\s|$)"))}function addClass(a,b){hasClass(a,b)||(a.className+=" "+b)}function removeClass(a,b){hasClass(a,b)&&(a.className=a.className.replace(RegExp("(\\s|^)"+b+"(\\s|$)")," "))};
            $(document).ready(function(){$("#twitter").getTwitter({userName:"FanaticosPorCom",numTweets:4,loaderText:"Carregando tweets...",slideIn:!0,showHeading:!1,headingText:"Ultimos Tweets",showProfileLink:!1})});$(document).ready(function(){$.piroBox_ext({piro_speed:700,bg_alpha:0.5,piro_scroll:!0,piro_drag:!1,piro_nav_pos:"bottom"});$("#login").click(function(){validaLogin($("#log"),$("#pwd"))})});$(window).load(function(){$("#facebook_like_box").html('<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Ffanaticosporcompra&amp;width=680&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23F7F7F7&amp;stream=false&amp;header=false&amp;appId=174792592599231" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:680px; height:290px;" allowTransparency="true"></iframe>')});$(document).ready(function() {$('#respostaNews').fadeOut(0);$('#enviar_newsEnviarForm').click(function(){var nome  = $("#news_nome").val();var email = $("#news_email").val();if (nome != '' && email != '') {$('#informativo').fadeTo("slow", 0.3);$.post("<?php echo $caminho; ?>news/",{nome:nome, email:email, ip_visitante:'<?php echo $_SERVER['REMOTE_ADDR']; ?>'},function(retorno){$('#respostaNews').html(retorno).fadeIn();$('#informativo').fadeTo("slow", 2);$('#respostaNews').fadeOut(3000);});}return false;});});
        </script>
    </head>    
    <body>
        <div id="fb-root"></div>
        <script async defer>(function(a,b,c){var d=a.getElementsByTagName(b)[0];a.getElementById(c)||(a=a.createElement(b),a.id=c,a.src="//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=174792592599231",d.parentNode.insertBefore(a,d))})(document,"script","facebook-jssdk");</script>
        <?php require_once("login/login.php"); ?>
        <div id="header">
            <div id="topo">
                <div id="intTopo">
                    <a href="<?php echo $caminho; ?>site/loja"><img id="logo" src="<?php echo $caminho; ?>images/logo.jpg" border="0"/></a>
                    <div id="fotoTopo">
                    </div>
                </div>
            </div>
        </div>
        <div id="container">
            <div id="intCont">
                <div id="barraMenuUp">
                    <ul id="menuUp">
                        <li><a href="<?php echo $caminho; ?>site/">Início</a></li>
                        <li><a href="<?php echo $caminho; ?>site/cadastro">Cadastre-se</a></li>
                        <li><a href="<?php echo $caminho; ?>site/leiloes">Leilões</a></li>
                        <li><a href="<?php echo $caminho; ?>site/departamentos">Departamentos</a></li>
                        <li onclick="window.open('http://www.youtube.com/user/fanaticosporcompras', '_blank')"><a>Depoimentos</a></li>
                        <li><a href="<?php echo $caminho; ?>site/contato">Contato</a></li>
                    </ul>
                    <input id="bSearchUp" class="bSearch" type="button" onclick="pesquisar('searchTop');"/>
                    <div id="divSearchTop"><input id="searchTop" type="text" placeholder="Fa&ccedil;a uma busca" onkeypress="OnEnter(event, 'searchTop');"/></div>
                </div>
                <div id="menuLat">
                    <div class="titMenuLat"><div class="itemMenuTit">Departamentos</div></div>
                    <div class="divListaLat">
                        <ul class="ulLat">
                            <?php
                            $banco = new cPDO();
                            $grupoPai = new produtos();

                            $sql = $grupoPai->ListaGrupos();
                            $row = $banco->query($sql)->fetch();

                            foreach ($banco->query($sql) as $row) {
                                ?>
                                <?php
                                if ($row['id_grupo'] == 1) {
                                    echo "<li onclick=\"__url('http://www.sabordoamor.com.br/')\">" . $row['descricao'] . "</li>";
                                } else {
                                    echo "<li onclick=\"__url('" . $caminho . "site/loja/" . $row['id_grupo'] . "')\">" . $row['descricao'] . "</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="titMenuLat"><div class="itemMenuTit">Sess&otilde;es</div></div>
                    <div class="divListaLat">
                        <div class="menu">
                            <ul class="ulLatMenu">
                                <?php
                                $banco = new cPDO();
                                $banco2 = new cPDO();
                                $categoriaPai = new produtos();
                                $categoriaFilho = new produtos();

                                $sql = $categoriaPai->ListaCategoriasPai();
                                $row = $banco->query($sql)->fetch();

                                foreach ($banco->query($sql) as $row) {
                                    $categoriaFilho->set(id_categoria, $row['id_categoria']);
                                    $sql2 = $categoriaFilho->ListaCategoriaFilho();
                                    $totalFilhos = $banco2->query($sql2)->rowCount();

                                    if ($totalFilhos > 0) {
                                        ?>
                                        <li>
                                            <a onclick="__url('<?php echo $caminho . "site/loja/0/" . $row['id_categoria']; ?>');"><?php echo $row['descricao']; ?></a>
                                            <?php
                                            $categoriaFilho->set(id_categoria, $row['id_categoria']);
                                            $sql2 = $categoriaFilho->ListaCategoriaFilho();
                                            ?>
                                            <ul>
                                                <?php
                                                foreach ($banco2->query($sql2) as $row_categoria) {
                                                    echo "<li onclick=\"__url('" . $caminho . "site/loja/0/" . $row_categoria['id_categoria'] . "')\"><a>" . $row_categoria['descricao'] . "</a></li>";
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                    <?php } else {
                                        ?>
                                        <li>
                                            <a href="<?php echo $caminho; ?>site/loja/0/<?php echo $row['id_categoria']; ?>"><?php echo $row['descricao']; ?></a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="titMenuLat"><div class="itemMenuTit">Leilões</div></div>
                    <div class="divListaLat">
                        <ul class="ulLat">
                            <li onClick="__url('http://games.fanaticosporcompras.com.br/site/')">Games</li>
                            <li onClick="__url('http://sexshop.fanaticosporcompras.com.br/site/leiloes/')">SexShop</li>
                        </ul>
                    </div>
                    <div class="titMenuLat"><div class="itemMenuTit">Enquete</div></div>
                    <div class="divListaLat">
                        <?php require_once(dirname(__FILE__) . '/enquete/enquete.php'); ?>
                    </div>
                    <div class="titMenuLat"><div class="itemMenuTit">Promo&ccedil;&atilde;o</div></div>
                    <div class="divListaLat">
                        <img class="promocao" src="<?php echo $caminho; ?>promocao/maxpayne3.jpg" title="Curta nossa Pagina no Facebook e concorra a um Game Max Payne 3 para Xbox 360 ou PS3" alt="Max Payne" onclick="window.open('https://www.facebook.com/fanaticosporgames.com.br', '_blank')"/>
                        <div class="clear"></div>
                    </div>

                    <?php
                    $promocao = new promocao();
                    $promocao->set(dt_publicacao, date('Y-m-d'));
                    $promocao->set(dt_fim, date('Y-m-d'));
                    $promocao->set(status, 'A');
                    $sql = $promocao->ListaPromocao();

                    $banco = new database();
                    $banco->connect();
                    $banco->sqlQuery($sql);
                    $row = $banco->fetch_object();
                    $totalPromocao = $banco->num_rows();

                    if ($totalPromocao > 0) {
                        ?>
                        <div class="titMenuLat"><div class="itemMenuTit">Ofertas</div></div>
                        <div class="divListaLat">
                            <div class="midia">
                                <?php
                                if ($banco->num_rows() > 0) {
                                    $banco3 = new database();
                                    $midia = new midia();
                                    ?>

                                    <ul>
                                        <?php
                                        $midia->set(id_documento, $row->id_documento);
                                        $midia->set(status, 'A');
                                        $midia->set(destaque, 'S');
                                        $midia->set(id_tp_midia, '1');
                                        $sql_midia = $midia->ListaMidia();
                                        $banco3->sqlQuery($sql_midia);
                                        $total_midia = $banco3->num_rows();
                                        $row_midia = $banco3->fetch_object();

                                        if ($total_midia > 0) {
                                            ?>
                                            <li class="encarte" title="Encarte" onclick="__url('<?php echo $caminho . 'encartes1/' . $row->id_promocao; ?>');">
                                                <img src="<?php echo $caminho . $row_midia->link; ?>" />
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                }
                                //require_once('encartes/encartes.php'); 
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div id="conteudo">
                    <?php
                    include("{$pasta}/" . anti_injection($pagina) . ".php");
                    ?>
                </div>
            </div>
        </div>
        <div id="footer">
            <div id="footerBack">
                <div id="intFooter">
                    <div id="divPesquisar">
                        <div id="divSearchBottom"><input id="searchBottom" type="text" placeholder="Digite sua busca" onkeypress="OnEnter(event, 'searchBottom');"/></div>
                        <input id="bSearchDown" class="bSearch" type="button" onclick="pesquisar('searchBottom')"/>
                    </div>
                    <div id="banRedes">
                        <div class="banners" onClick="window.open('http://www.fanaticosporcompras.com.br/');"><img src="<?php echo $caminho; ?>images/BannerFooter1.png"/></div>
                        <div class="banners" onClick="window.open('http://www.fanaticosporgames.com.br/');"><img src="<?php echo $caminho; ?>images/BannerFooter2.png"/></div>
                        <div class="banners" onClick="window.open('http://www.sexshop.fanaticosporcompras.com.br/site/');"><img src="<?php echo $caminho; ?>images/BannerFooter3.png"/></div>
                        <div id="iconRedes">
                            <div id="intIconRedes">
                                <a href="https://www.facebook.com/fanaticosporcompra" target="_blank"><div id="iconFace" class="redes"></div></a>
                                <a href="https://twitter.com/FanaticosPorCom" target="_blank"><div id="iconTwit" class="redes"></div></a>
                                <a href="#" target="_blank"><div id="iconOrkut" class="redes"></div></a>
                                <a href="http://www.youtube.com/user/fanaticosporcompras" target="_blank"><div id="iconFeeds" class="redes"></div></a>
                            </div>
                        </div>
                    </div>
                    <div id="boxRedes">
                        <div id="twitter">
                            <img src="<?php echo $caminho; ?>images/twitter.png" />
                        </div>
                        <div id="facebook_like_box">
                        </div>
                        <div id="boxFooter">
                            <div id="apoiadores">
                                <p>Formas de Pagamentos</p>
                                <img src="<?php echo $caminho; ?>images/apoiadores.png" />
                                <div class="clear"></div>
                            </div>
                            <div id="informativo">
                                <form name="newsletter" id="newsletter" method="post" action="#">
                                    <p id="titInfo">Informativo</p>
                                    <p id="textInfo">Cadastre seu e-mail para receber as novidades!</p>
                                    <input type="text" id="news_nome" placeholder="Digite seu nome" onblur="formIsEmpty(this)"/><br />
                                    <input type="text" id="news_email" placeholder="Digite seu email" onblur="validaEmail(this), formIsEmpty(this)"/>
                                    <input type="button" id="enviar_newsEnviarForm" border="0" value="Enviar"/>
                                    <div id="respostaNews"></div>
                                </form>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div id="rodape">
                    <div id="intRodape">
                        <p>Fanáticos por Compras ©<?php echo date('Y'); ?>. Todos os direitos reservados.</p>
                        <a href="<?php echo $caminho; ?>site/">In&iacute;cio</a>|
                        <a href="<?php echo $caminho; ?>site/cadastro">Cadastre-se</a>|
                        <a href="<?php echo $caminho; ?>site/leiloes">Leilões</a>|
                        <a href="<?php echo $caminho; ?>site/comofunciona">Como Funciona</a>|
                        <a href="<?php echo $caminho; ?>site/perguntas">Perguntas Frequentes</a>|
                        <a href="<?php echo $caminho; ?>privacidade/">Privacidade</a>|
                        <a href="<?php echo $caminho; ?>termos/">Condi&ccedil;&otilde;es de Uso</a>|
                        <a href="<?php echo $caminho; ?>site/quemsomos">Quem Somos</a>|
                        <a href="<?php echo $caminho; ?>site/contato">Contato</a>
                        <a href="http://www.aliancaglobal.com.br" target="_blank">
                            <img src="<?php echo $caminho; ?>images/logoAG.jpg" alt="Alian&ccedil;a Global" title="Desenvolvido Por Alin&ccedil;a Global" border="0"/></a>
                    </div>
                </div>
            </div>
            <script async defer type="text/javascript" src="<?php echo $caminho; ?>js/jquery.alerts.js"></script>
            <script type="text/javascript">
                var socket=io.connect("http://localhost:80",{reconnect:!0,"reconnection delay":50,"max reconnection attempts":1E3,secure:!1});socket.emit("userconected","");socket.on("showmessage",function(a){document.getElementById("hora").innerHTML=a.hora});
            </script>
    </body>
</html>