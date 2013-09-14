<?php

require_once("caminho.php");
require_once("class/funcoes.php");
require_once('class/mysql.class.php');
require_once("class/login.class.php");

$email = htmlspecialchars(strip_tags($_POST['email']));
$senha = htmlspecialchars(strip_tags($_POST['senha']));

if ($email != '' && $senha != '') {

    $login = new login();
    $login->set(login, anti_injection($email));
    $login->set(senha, anti_injection($senha));

    $sql = $login->Logar();

    $banco = new database();
    $banco->connect();
    $banco->sqlQuery($sql);

    if ($usuario != '0') {
        if (!isset($_SESSION)) {
            session_start();
        }
        $usuario = explode('|', $usuario);
        $_SESSION['nome'] = $usuario['0'];
        $_SESSION['id'] = $usuario['1'];

        echo "<script>open('" . $caminho . "site/','_parent')</script>";
    } else {
        echo "Usu&aacute;rio ou senha incorretos";
    }
} else {
    echo "Preenha os campos obrigatorios";
}
?>
