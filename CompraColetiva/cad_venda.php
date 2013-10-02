<?php
require_once("class/funcoes.php");
require_once("class/mysql.class.php");
require_once("class/usuario.class.php");
require_once("class/endereco.class.php");
require_once("class/pdo.class.php");

$id_oferta = htmlspecialchars(strip_tags($_POST['id_oferta']));
$id_usuario = htmlspecialchars(strip_tags($_POST['id_usuario']));
$qtd_vendida = htmlspecialchars(strip_tags($_POST['qtd_vendida']));

$banco = new cPDO();

$sql = "INSERT INTO venda VALUES ('0','" . $id_oferta . "','" . $id_usuario . "',NOW(),'PENDENTE')";
$sqlOferta = "UPDATE oferta SET qtd_vendida='" . ($qtd_vendida + 1) . "' where id='" . $id_oferta . "'";
$banco->query($sql);
$banco->query($sqlOferta);
?>
