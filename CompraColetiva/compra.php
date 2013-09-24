<?php

if (!isset($_SESSION)) {
    session_start();
}

echo $_SESSION['id'];
require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("class/oferta.class.php");
require_once("class/usuario.class.php");
require_once("class/mysql.class.php");
//require_once("paypal/pay_pal.class.php");

$banco = new cPDO();
$preco_total = 0;
$id_usuario = $_SESSION['id'];
echo $_SESSION['id'];
//$id_endereco = anti_injection($_POST['enderecoEntrega']);


$usuario = new usuario();
$usuario->set(id, $id_usuario);
$sql = $usuario->ListaUsuario();
//echo $sql;
$row_pessoa = $banco->query($sql)->fetch();
//echo 'nome: '. $row_pessoa['nome'];

$produto = new oferta();

$tokenP = 'AQU0e5vuZCvSg-XJploSa.sGUDlpAO4SVgtx9mrfPcJ4YrsNNPncxv4t';
$usuarioP = 'anacm.maciel_api1.gmail.com';
$senhaP = '65U5LZG2Z3SMD4Y3';

//echo $tokenP . '<br />';
//echo $usuarioP . '<br />';
//echo $senhaP . '<br />';
//echo $emailP . '<br />';
//
//PAYPAL
$totalIt = 0;

$nvp['L_PAYMENTREQUEST_0_AMT'] = '2,00';
$nvp['L_PAYMENTREQUEST_0_NAME'] = 'teste';
$nvp['L_PAYMENTREQUEST_0_QTY'] = '1';

$nvp['PAYMENTREQUEST_0_AMT'] = '2,00';
$nvp['PAYMENTREQUEST_0_CURRENCYCODE'] = 'BRL';
$nvp['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
$nvp['RETURNURL'] = 'http://www.yourwebsite.com/confirm.php';
$nvp['CANCELURL'] = 'http://www.yourwebsite.com/confirm.php';
$nvp['METHOD'] = 'SetExpressCheckout';
$nvp['VERSION'] = '84';
$nvp['PWD'] = $senhaP;
$nvp['USER'] = $usuarioP;
$nvp['SIGNATURE'] = $tokenP;
//echo $senhaP;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
//curl_setopt($curl, CURLOPT_URL, 'https://api-3t.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvp));
$response = urldecode(curl_exec($curl));
curl_close($curl);
echo $response;
$responseNvp = array();
if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
    foreach ($matches['name'] as $offset => $name) {
        $responseNvp[$name] = $matches['value'][$offset];
    }
}
$token = $responseNvp['TOKEN'];

if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
    $query = array(
        'cmd' => '_express-checkout',
        'token' => $responseNvp['TOKEN']
    );
    echo "<script type=\"text/javascript\">__url('" . $paypalURL . "?" . http_build_query($query) . "');</script>";
} else {
    echo 'Falha na transacao';
}
?>