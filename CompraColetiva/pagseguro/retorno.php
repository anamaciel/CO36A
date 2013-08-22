<?php

require_once("PagSeguroLibrary.php");
require_once("../class/funcoes.php");
require_once("../class/pdo.class.php");
require_once("../class/tp_pagamento.class.php");

$code = $_POST['notificationCode'];

$pg = new tp_pagamento();
$pg->set(id_tp_pagamento, '1');
$sql = $banco->query($pg->ListaTpPagamento())->fetch();
$row_pg = $banco->query($sql['Msg'])->fetch();

function printTransaction(PagSeguroTransaction $transaction) {
    //echo $transaction->getStatus()->getTypeFromValue();
    switch ($transaction->getStatus()) {
        case "1":
            $status = "A";
            break;
        case "2":
            $status = "A";
            break;
        case "3":
            $status = "P";
            break;
        case "4":
            $status = "P";
            break;
        case "5":
            $status = "A";
            break;
        case "6":
            $status = "C";
            break;
        case "7":
            $status = "C";
            break;
    }

    $banco = new cPDO();

    $row = $banco->query("CALL listaCompras('', '" . $transaction->getReference() . "', '', '', '', '', '', '')")->fetch();
    $row = $banco->query($row['Msg'])->fetch();

    $ctReceber = $banco->query("CALL gravaCtReceber('" . $row['id_ct_receber'] . "', '" . $row['id_pessoa'] . "', '" . $row['id_tp_pagamento'] . "', '" . $row['id_endereco'] . "', '" . $row['id_pedido'] . "', '" . $row['id_leilao'] . "', '" . $row['dt_registro'] . "', '" . date('Y-m-d H:i:s') . "', '" . $status . "', 'L', '" . $row['nr_postagem'] . "', '" . $row['preco_venda'] . "', '" . $row['preco_frete'] . "', '" . $row['desconto'] . "', '" . $row['tipo'] . "', '" . $row['preco_frete_correio'] . "', '" . $row['token'] . "', '" . $row['obs'] . "', '" . $row['tipo_frete'] . "')")->fetch();

    $id_ctReceber = $row['id_ct_receber'];

    if ($transaction->getEscrowEndDate() != '') {
        $dtPag = converte_dataPg($transaction->getEscrowEndDate());
    } else {
        $dtPag = date('Y-m-d H:i:s');
    }

    $row_des = $banco->query("CALL gravaDespCtReceber('', '" . $id_ctReceber . "', '" . $transaction->getGrossAmount() . "', '" . $transaction->getDiscountAmount() . "', '" . $transaction->getFeeAmount() . "', '" . $transaction->getExtraAmount() . "', '" . $transaction->getNetAmount() . "', '" . $transaction->getShipping()->getCost() . "', '" . $dtPag . "', '" . $transaction->getInstallmentCount() . "', '" . $transaction->getItemCount() . "', '" . $transaction->getPaymentMethod()->getType()->getTypeFromValue() . "')")->fetch();
    
}

try {
    $credentials = new PagSeguroAccountCredentials($row_pg['email'], $row_pg['token']);

    $transaction = PagSeguroTransactionSearchService::searchByCode($credentials, $code);

    printTransaction($transaction);
} catch (PagSeguroServiceException $e) {
    die($e->getMessage());
    exit;
}
?>