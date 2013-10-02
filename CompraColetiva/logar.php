<?php

require_once("caminho.php");
require_once("class/funcoes.php");
require_once('class/mysql.class.php');
require_once("class/login.class.php");

$email = htmlspecialchars(strip_tags($_POST['email']));
$senha = htmlspecialchars(strip_tags($_POST['senha']));

if ($email != '' && $senha != '') {

    error_reporting(E_ALL);
    ini_set('display_errors', 'off');
//    echo encode5t($senha);
    $login = new login();
    $login->set(login, anti_injection($email));
    $login->set(senha, anti_injection(encode5t($senha)));

    $sql = $login->Logar();

    $banco = new database();
    $banco->connect();
    $banco->sqlQuery($sql);

    if ($banco->num_rows() == 0) {
        echo "Usu&aacute;rio ou senha incorretos";
    } else {

        if (!isset($_SESSION)) {
            session_start();
        }

        $usuario = $banco->fetch_assoc();

        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['email'] = $usuario['email'];

        echo "<script>open('" . $caminho . "site/','_parent')</script>";
    }
} else {
    echo "Preenha os campos obrigatorios";
}
?>
