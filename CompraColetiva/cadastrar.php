<?php
require_once("class/funcoes.php");
require_once("class/mysql.class.php");
require_once("class/usuario.class.php");
require_once("class/endereco.class.php");
require_once("class/pdo.class.php");

error_reporting(E_ALL);
ini_set('display_errors', 'off');

$nome = htmlspecialchars(strip_tags($_POST['nome']));
$sobrenome = htmlspecialchars(strip_tags($_POST['sobrenome']));
$cpf = htmlspecialchars(strip_tags($_POST['cpf']));
$rg = htmlspecialchars(strip_tags($_POST['rg']));
$nascimento = htmlspecialchars(strip_tags($_POST['nascimento']));
$sexo = htmlspecialchars(strip_tags($_POST['sexo']));
$logradouro = htmlspecialchars(strip_tags($_POST['logradouro']));
$numero = htmlspecialchars(strip_tags($_POST['numero']));
$complemento = htmlspecialchars(strip_tags($_POST['complemento']));
$bairro = htmlspecialchars(strip_tags($_POST['bairro']));
$cep = htmlspecialchars(strip_tags($_POST['cep']));
$estado = htmlspecialchars(strip_tags($_POST['estado']));
$cidade = htmlspecialchars(strip_tags($_POST['cidade']));
$email = htmlspecialchars(strip_tags($_POST['email']));
$senha = htmlspecialchars(strip_tags($_POST['senha']));
$confirma = htmlspecialchars(strip_tags($_POST['confirma']));

$banco = new database();
$banco->connect();

$bancoPDO = new cPDO();

$usuario = new usuario();
$usuario->set(nome, $nome);
$usuario->set(sobrenome, $sobrenome);
$usuario->set(sexo, $sexo);
$usuario->set(nascimento, converte_data($nascimento));
$usuario->set(email, $email);
$usuario->set(senha, encode5t($senha));
$usuario->set(tipo, $tipo);

$sql = $usuario->GravaUsuario();
echo $sql;
$banco->sqlQuery($sql);

$idUsuario = $banco->insert_id();
echo "USUARIO" . $idUsuario;
if ($idUsuario == 0) {
    echo "Erro ao gravar registro";
} else {
    echo $idUsuario;
    $endereco = new endereco();
    $endereco->set(cidade_id, $cidade);
    $endereco->set(logradouro, $logradouro);
    $endereco->set(numero, $numero);
    $endereco->set(complemento, $complemento);
    $endereco->set(bairro, $bairro);
    $endereco->set(tp_endereco, $tipo);
    $endereco->set(usuario_id, $idUsuario);
    
    $sql = $endereco->GravaEndereco();
    echo $sql;
    $banco->sqlQuery($sql);
}
?>
