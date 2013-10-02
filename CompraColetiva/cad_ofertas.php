<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("class/funcoes.php");
require_once("class/mysql.class.php");
require_once("class/usuario.class.php");
require_once("class/endereco.class.php");
require_once("class/oferta.class.php");
require_once("class/pdo.class.php");

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$id_usuario = $_SESSION['id'];

$nome = htmlspecialchars(strip_tags($_POST['nome']));
$descricao = htmlspecialchars(strip_tags($_POST['descricao']));
$data_inicio = htmlspecialchars(strip_tags($_POST['data_inicio']));
$data_fim = htmlspecialchars(strip_tags($_POST['data_fim']));
$qtd_minima = htmlspecialchars(strip_tags($_POST['qtd_minima']));
$valor_real = htmlspecialchars(strip_tags($_POST['valor_real']));
$valor_liquido = htmlspecialchars(strip_tags($_POST['valor_liquido']));

$banco = new database();
$banco->connect();

$bancoPDO = new cPDO();
$oferta = new oferta();
$oferta->set('nome', $nome);
$oferta->set('descricao', $descricao);
$oferta->set('data_fim', converte_dateTime($data_fim));
$oferta->set('data_inicio', converte_dateTime($data_inicio));
$oferta->set('qtd_minima', $qtd_minima);
$oferta->set('valor_real', $valor_real);
$oferta->set('valor_liquido', $valor_liquido);
$oferta->set('usuario_id', $id_usuario);

$uploaddir = '/var/www/uploads/';
$uploadfile = $uploaddir . $_FILES['userfile']['name'];
print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $_FILES['userfile']['name'])) {
    $sql = $oferta->GravaOferta();
} else {
   echo 'Erro ao gravar';
}


//echo $sql;
$banco->sqlQuery($sql);


?>
