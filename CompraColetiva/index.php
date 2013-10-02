<?php
if (!isset($_SESSION)) {
    session_start();
}
$vlM = 0;
error_reporting(E_ALL);
ini_set('display_errors', 'off');

require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("caminho.php");

$atual = ($_GET['pg'] != '') ? $_GET['pg'] : 'home';
$permissao = array('index', 'login', 'home', 'termos', 'perguntas', 'cadastro', 'contato', 'ofertas', 'ofertas_passadas', 'ofertaDetalhe','conta','minhas_compras','minhas_ofertas','meus_dados','pedido', 'minha_oferta_detalhe','parceiros', 'como_funciona', 'termos', 'editCadastro', 'uploadFoto');

if (substr_count($atual, '/') > 0) {
    $atual = explode('/', $atual);
    $pagina = (!file_exists($caminho . "site/" . $atual[0] . '.php') && in_array($atual[0], $permissao)) ? $atual[0] : 'home';
    $id = anti_injection($atual[1]);
    $id2 = anti_injection($atual[2]);
} else {
    $pagina = (!file_exists($caminho . "site/" . $atual . '.php') && in_array($atual, $permissao)) ? $atual : 'home';
    $id = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Home</title>
        <meta charset="utf-8">
        <link rel="icon" href="<?php echo $caminho; ?>images/favicon.ico">
        <link rel="shortcut icon" href="<?php echo $caminho; ?>images/favicon.ico" />
        <link rel="stylesheet" href="<?php echo $caminho; ?>css/style.css">
        <link rel="stylesheet" href="<?php echo $caminho; ?>css/form.css">
        <link rel="stylesheet" href="<?php echo $caminho; ?>css/slider.css">
        <link rel="stylesheet" href="<?php echo $caminho; ?>css/touchTouch.css">
        <script src="<?php echo $caminho; ?>js/jquery.js"></script>
        <script async defer type="text/javascript" src="http://localhost:8088/socket.io/socket.io.js"></script> 
        <script src="<?php echo $caminho; ?>js/sForm.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery-migrate-1.1.1.js"></script>
        <script src="<?php echo $caminho; ?>js/superfish.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery.jqtransform.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery.equalheights.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery.easing.1.3.js"></script>
        <script src="<?php echo $caminho; ?>js/tms-0.4.1.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery-ui-1.10.3.custom.min.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery.ui.totop.js"></script>
        <script src="<?php echo $caminho; ?>js/touchTouch.jquery.js"></script>
        <script src="<?php echo $caminho; ?>js/jquery.maskedinput-1.1.4.js"></script>

        <script>
            $(window).load(function() {
                $('.slider')._TMS({
                    show: 0,
                    pauseOnHover: false,
                    prevBu: '.prev',
                    nextBu: '.next',
                    playBu: false,
                    duration: 800,
                    preset: 'random',
                    pagination: false, //'.pagination',true,'<ul></ul>'
                    pagNums: false,
                    slideshow: 8000,
                    numStatus: false,
                    banners: true,
                    waitBannerAnimation: false,
                    progressBar: false
                });
                $("#tabs").tabs();

                $().UItoTop({easingType: 'easeOutQuart'});
            });

        </script>
        <!--[if lt IE 8]>
                <div style=' clear: both; text-align:center; position: relative;'>
                        <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
                                <img src="<?php echo $caminho; ?>http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
                        </a>
               </div>
       <![endif]-->
        <!--[if lt IE 9]>
                <script src="<?php echo $caminho; ?>js/html5shiv.js"></script>
                <link rel="stylesheet" media="screen" href="<?php echo $caminho; ?>css/ie.css">

        <![endif]-->
    </head>
    <body	class="page1">
        <!--==============================header=================================-->
        <header> 
            <div class="container_12">
                <div class="grid_12"> 
                    <h1><a href="<?php echo $caminho; ?>site/"><img src="<?php echo $caminho; ?>images/logo.png" alt="logo"></a> </h1>


                    <div class="clear"></div>
                </div>
                <div class="menu_block">
                    <nav class="" >
                        <ul class="sf-menu">
                            <li class="current"><a href="<?php echo $caminho; ?>site/">Home</a></li>
                            <li class="with_ul"><a href="<?php echo $caminho; ?>site/ofertas">Ofertas</a>
                                <!--                                <ul>
                                                                    <li><a href="#"> Agency</a></li>
                                                                    <li><a href="#">News</a></li>
                                                                    <li><a href="#">Team</a></li>
                                                                </ul>-->
                            </li>
                            <li><a href="<?php echo $caminho; ?>site/ofertas_passadas">Ofertas Passadas</a></li>
                            <li><a href="<?php echo $caminho; ?>site/parceiros">Seja Parceiro</a></li>
                            <li><a href="<?php echo $caminho; ?>site/cadastro">Cadastro</a></li>
                            <li><a href="<?php echo $caminho; ?>site/contato">Contato</a></li>
                        </ul>
                    </nav>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </header>

        <div class="main">
            <?php
            if ($_SESSION['id'] != '') {
                echo '<div class="login"><a href = '."'". $caminho . 'site/conta'."'". '">Minha Conta</a> | <a href = '."'". $caminho . 'sair/'."'". '">Sair</a></div>';
            } else {
                echo '<div class="login" onclick="javascript:location.href = '."'". $caminho . 'site/login'."'". '">Login</div>';
            }
            ?>
            
            <!--=======conteudo================================-->
            <?php
            include("{$pasta}/" . anti_injection($pagina) . ".php");
            ?>

            <div class="bottom_block">
                <div class="container_12">
                    <div class="grid_2 prefix_2">
                        <ul>
                            <li><a href="<?php echo $caminho; ?>site/ofertas">Ofertas</a></li>
                            <li><a href="<?php echo $caminho; ?>site/ofertas_passadas">Ofertas Passadas</a></li>
                        </ul>
                    </div>
                    <div class="grid_2">
                        <ul>
                            <li><a href="<?php echo $caminho; ?>site/cadastro">Cadastro</a></li>
                            <li><a href="<?php echo $caminho; ?>site/como_funciona">Como Funciona</a></li>
                        </ul>
                    </div>
                    <div class="grid_2">
                        <ul>
                            <li><a href="<?php echo $caminho; ?>site/perguntas">Perguntas Frequentes</a></li>
                            <li><a href="<?php echo $caminho; ?>site/termos">Termos de Uso</a></li>
                        </ul>
                    </div>
                    <div class="grid_2" >
                        <h4><a href="<?php echo $caminho; ?>site/contato">Contato:</a></h4>
                        TEL: +55 44 3523-4156<br><a href="#">contato@outletmix.com.br</a>

                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <!--==============================footer=================================-->

        </div>
        <footer>		
            <div class="container_12">
                <div class="grid_12">
                    <div class="socials">
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                    </div>
                    <div class="copy">
                        Journey &copy; 2013 | <a href="#">Política de Privacidade</a>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </footer>
    </body>
</html>