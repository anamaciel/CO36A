<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("class/funcoes.php");
require_once("class/pdo.class.php");
require_once("pagseguro/pag_seguro.class.php");
require_once("paypal/pay_pal.class.php");

$pag_seguro = new pag_seguro();
$pay_pal = new pay_pal();

$banco = new cPDO();
$preco_total = 0;
$id_pessoa = anti_injection(decode5t($_SESSION['id']));
$id_endereco = anti_injection($_POST['enderecoEntrega']);
//$id_tp_pagamento = anti_injection($_POST['tipoPagamento']);
$id_tp_pagamento = 2;

$cliente = new cliente();
$cliente->set(id_pessoa, $id_pessoa);
$sql = $cliente->ListaCliente();
//echo $sql;
$row_pessoa = $banco->query($sql)->fetch();
//echo 'nome: '. $row_pessoa['nome'];

$produto = new produtos();

$tokenP = $row_pg['token'];
$usuarioP = $row_pg['login'];
$senhaP = $row_pg['senha'];
$emailP = $row_pg['email'];

//echo $tokenP . '<br />';
//echo $usuarioP . '<br />';
//echo $senhaP . '<br />';
//echo $emailP . '<br />';
//
//PAGSEGURO  
if ($id_tp_pagamento == '1') {
    $valida = $pag_seguro->validaDadosCadastrais($cepDestino, $cepOrigem, $row_pessoa['nome'], $row_pessoa['email'], $ddd, $tel, $emailP, $tokenP, $cpf);
    if ($valida == '') {
        require_once("pagseguro/criaPagamento.class.php");
        $pagseguro = new pagseguro();
        $pagseguro->set(emailP, $emailP);
        $pagseguro->set(tokenP, $tokenP);


        if (count($_SESSION['carrinho']) > 0) {
            $id_pedido = $banco->query("CALL gravaPedido('" . $idPedido . "', '', 'A')")->fetch();
            $verificaItens = $pag_seguro->gravaItensPagSeguro($id_pedido["Msg"], $id_pessoa);

            //echo 'TESTE: '. $verificaItens;

            if ($verificaItens == '') {

                foreach ($_SESSION['carrinho'] as $id => $qtd) {
                    $produto->set(id_produtos, $id);
                    $sql = $produto->ListaProdutos();
                    $rowProdutos = $banco->query($sql)->fetch();
                    $idPP = $rowProdutos['id_preco_produto'];
                    $idProdutos = $rowProdutos['id_produtos'];


                    $lances = new lances();
                    $lances->set(id_produtos, $id);
                    $sql = $lances->Listalances();
                    $rowLances = $banco->query($sql)->fetch();


                    $pagseguro->set(produto, $rowProdutos['titulo']);
                    $pagseguro->set(quantidade, $qtd);
                    $pagseguro->set(valor, number_format($rowProdutos['preco_venda'], 2));
                    $pagseguro->addProduto();
                }

                $valorFreteTotal = $pag_seguro->calculaFretePagSeguro($tipo_servico, $cepOrigem, $cepDestino);
                $preco_total = $pag_seguro->precoTotalPagSeguro();

                $preco_total = $preco_total + $valorFreteTotal;


                if ($valorFreteTotal > 0) {
                    $pagseguro->set(produto, 'Frete');
                    $pagseguro->set(quantidade, 1);
                    $pagseguro->set(valor, $valorFreteTotal);
                    $pagseguro->addProduto();
                }

                $pagseguro->set(referencia, $id_pedido["Msg"]);
                $pagseguro->set(frete, $tipo_frete);
                $pagseguro->set(cep, $row_endereco['cep']);
                $pagseguro->set(endereco, $row_endereco['endereco']);
                $pagseguro->set(nr, $row_endereco['nr']);
                $pagseguro->set(complemento, $row_endereco['complemento']);
                $pagseguro->set(bairro, $row_endereco['bairro']);
                $pagseguro->set(cidade, $row_endereco['desc_cidade']);
                $pagseguro->set(uf, $row_endereco['uf']);
                $pagseguro->set(cliente, $row_pessoa['nome']);
                $pagseguro->set(email, $row_pessoa['email']);
                $pagseguro->set(ddd, substr($row_pessoa['telefone'], 0, 2));
                $pagseguro->set(telefone, substr($row_pessoa['telefone'], 2, 9));
                $token = $pagseguro->geraUrl();
                //echo $token;

                $ctReceber = $banco->query("CALL gravaCtReceber('" . $idCtReceber . "', '" . $id_pessoa . "', '" . $id_tp_pagamento . "', '" . $id_endereco . "', '" . $id_pedido["Msg"] . "', null, '" . $dtRegistro . "', null , 'A', 'A', null , '" . $preco_total . "', '" . $valorFreteTotal . "', '" . $desc . "', 'V', '0', '" . $token . "', '" . $obs . "', '" . $tipo_frete . "')")->fetch();

                $id_ctReceber = $ctReceber["Msg"];

                if ($ctReceber["Msg"] > 0) {
                    unset($_SESSION['carrinho']);
                    $pag_seguro->redirecionaPagSeguro($token);
                }
            } else {
                ?> 
                <div class="erroCarrinho">
                    <fieldset class="listaField bordaArredondada_10">
                        <legend><img src="<?php echo $caminho; ?>images/icones/cross-circle.png" align="absmiddle" />ERRO</legend>
                        <p><?php echo $verificaItens; ?></p>
                        <input type="button" value="Voltar ao Carrinho" class="btVtCarrinho" title="Voltar ao carrinho" onclick="__url('<?php echo $caminho; ?>site/carrinho_lista/')" />
                    </fieldset>
                </div>
                <?php
            }
        }
    } else {
        ?>
        <div class="erroCarrinho">
            <fieldset class="listaField bordaArredondada_10">
                <legend><img src="<?php echo $caminho; ?>images/icones/cross-circle.png" align="absmiddle" />ERRO</legend>
                <p><?php echo $valida; ?></p>
                <input type="button" value="Voltar ao Carrinho" class="btVtCarrinho" title="Voltar ao carrinho" onclick="__url('<?php echo $caminho; ?>site/carrinho_lista/')" />
            </fieldset>
        </div>
        <?php
    }
}


//PAYPAL
if ($id_tp_pagamento == '2') {
    $totalIt = 0;

    $nvp['L_PAYMENTREQUEST_0_AMT' . $totalIt] = number_format($rowProdutos['preco_venda'], 2);
    $nvp['L_PAYMENTREQUEST_0_NAME' . $totalIt] = $rowProdutos['titulo'];
    $nvp['L_PAYMENTREQUEST_0_QTY' . $totalIt] = $qtd;

    $nvp['PAYMENTREQUEST_0_AMT'] = number_format($preco_total, 2);
    $nvp['PAYMENTREQUEST_0_CURRENCYCODE'] = 'BRL';
    $nvp['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
    $nvp['RETURNURL'] = 'http://games.fanaticosporcompras.com.br/paypal/retorno.php';
    $nvp['CANCELURL'] = 'http://games.fanaticosporcompras.com.br/paypal/cancelar.php';
    $nvp['METHOD'] = 'SetExpressCheckout';
    $nvp['VERSION'] = '84';
    $nvp['PWD'] = $senhaP;
    $nvp['USER'] = $usuarioP;
    $nvp['SIGNATURE'] = $tokenP;
//echo $senhaP;

    $curl = curl_init();
//curl_setopt($curl, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
    curl_setopt($curl, CURLOPT_URL, 'https://api-3t.paypal.com/nvp'); //Link para ambiente de teste: https://api-3t.paypal.com/nvp
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($nvp));
    $response = urldecode(curl_exec($curl));
    curl_close($curl);
//echo $response;
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
        echo 'Falha na transa��o';
    }
}
?>