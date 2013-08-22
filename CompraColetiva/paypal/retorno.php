<?php

error_reporting(E_STRICT);
ini_set('display_errors', 'On');
require_once("../class/funcoes.php");
require_once("../class/pdo.class.php");
require_once("../class/tp_pagamento.class.php");

$banco = new cPDO();
$pg = new tp_pagamento();
$pg->set(id_tp_pagamento, '2');
$sql = $banco->query($pg->ListaTpPagamento())->fetch();
$row_pg = $banco->query($sql['Msg'])->fetch();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $nvp = array(
        'TOKEN' => $token,
        'METHOD' => 'GetExpressCheckoutDetails',
        'VERSION' => '84',
        'PWD' => $row_pg['senha'],
        'USER' => $row_pg['login'],
        'SIGNATURE' => $row_pg['token']
    );

    $curl = curl_init();

    //curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
    curl_setopt($curl, CURLOPT_URL, 'https://api-3t.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvp));

    $response = urldecode(curl_exec($curl));
    $responseNvp = array();

    if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
        foreach ($matches['name'] as $offset => $name) {
            $responseNvp[$name] = $matches['value'][$offset];
        }
    }

    if (isset($responseNvp['TOKEN']) && isset($responseNvp['ACK'])) {
        if ($responseNvp['TOKEN'] == $token && $responseNvp['ACK'] == 'Success') {
            $nvp['PAYERID'] = $responseNvp['PAYERID'];
            $nvp['PAYMENTREQUEST_0_AMT'] = $responseNvp['PAYMENTREQUEST_0_AMT'];
            $nvp['PAYMENTREQUEST_0_CURRENCYCODE'] = $responseNvp['PAYMENTREQUEST_0_CURRENCYCODE'];
            $nvp['METHOD'] = 'DoExpressCheckoutPayment';
            $nvp['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';

            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvp));

            $response = urldecode(curl_exec($curl));
            $responseNvp = array();

            if (preg_match_all('/(?<name>[^\=]+)\=(?<value>[^&]+)&?/', $response, $matches)) {
                foreach ($matches['name'] as $offset => $name) {
                    $responseNvp[$name] = $matches['value'][$offset];
                }
            }

            $banco = new cPDO();
            $row = $banco->query("CALL listaCtReceber('', '', '', '', '', '', '" . $token . "', '', '', '', '', '')")->fetch();
            $row = $banco->query($row['Msg'])->fetch();
            $id_ctReceber = $row['id_ct_receber'];

            if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {
                $status = 'P';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Denied') {
                $status = '';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Expired') {
                $status = 'C';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Failed') {
                $status = 'C';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Reversed') {
                $status = '';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Processed') {
                $status = 'P';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Voided') {
                $status = '';
            } else if ($responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Refunded') {
                $status = 'C';
            } else {
                $status = '';
            }

            if ($status != '') {
                $ctReceber = $banco->query("CALL gravaCtReceber('" . $id_ctReceber . "', '" . $row['id_pessoa'] . "', '" . $row['id_tp_pagamento'] . "', '" . $row['id_endereco'] . "', '" . $row['id_pedido'] . "', '" . $row['id_leilao'] . "', '" . $row['dt_registro'] . "', '" . date('Y-m-d H:i:s') . "', '" . $status . "', 'L', '" . $row['nr_postagem'] . "', '" . $row['preco_venda'] . "', '" . $row['preco_frete'] . "', '" . $row['desconto'] . "', '" . $row['tipo'] . "', '" . $row['preco_frete_correio'] . "', '" . $row['token'] . "', '" . $row['obs'] . "', '" . $row['tipo_frete'] . "')")->fetch();
                $row_des = $banco->query("CALL gravaDespCtReceber('', '" . $id_ctReceber . "', '" . $responseNvp['PAYMENTINFO_0_AMT'] . "', '0', '" . $responseNvp['PAYMENTINFO_0_FEEAMT'] . "', '" . $responseNvp['PAYMENTINFO_0_SETTLEAMT'] . "', '0', '" . $responseNvp['mc_shipping'] . "', '" . date('Y-m-d H:i:s') . "', '" . $responseNvp['mc_handling'] . "', '" . $responseNvp['num_cart_items'] . "', '')")->fetch();
                echo "<script type=\"text/javascript\">
function __url(url) {
    location.href=url;		
}                    
__url('http://games.fanaticosporcompras.com.br/site/minhascompras');</script>";
            }
        } else {
            echo 'Não foi possível concluir a transação';
            echo "<script type=\"text/javascript\">
function __url(url) {
    location.href=url;		
}                    
__url('http://games.fanaticosporcompras.com.br/site/minhascompras');</script>";
        }
    } else {
        echo 'Não foi possível concluir a transação';
        echo "<script type=\"text/javascript\">
function __url(url) {
    location.href=url;		
}                    
__url('http://games.fanaticosporcompras.com.br/site/minhascompras');</script>";
    }

    curl_close($curl);
}
?>