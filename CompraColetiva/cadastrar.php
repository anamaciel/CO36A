<?php


$nome = htmlspecialchars(strip_tags($_POST['nome']));
$sobrenome = htmlspecialchars(strip_tags($_POST['sobrenome']));
$cpf = htmlspecialchars(strip_tags($_POST['cpf']));
$rg = htmlspecialchars(strip_tags($_POST['rg']));
$nascimento = converte_data(htmlspecialchars(strip_tags($_POST['nascimento'])));
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


?>
