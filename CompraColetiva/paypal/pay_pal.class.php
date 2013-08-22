<?php

require_once("class/produtos.class.php");
require_once("class/pdo.class.php");

class pay_pal {

    public function verificaItensPayPal($id_pedido, $id_pessoa) {
        $produto = new produtos();
        $banco = new cPDO();
        $pagseguro = new pagseguro();

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

            $id_lances = $rowLances['id_lances'];
            $qtdLances = $rowLances['qtd'];

            $resultado = $this->validaItensPayPal($rowProdutos['id_produtos'], $rowProdutos['qtd_estoque'], utf8_encode($rowProdutos['titulo']), $idPP, $id_lances, $id_pessoa, $id_pedido, $rowProdutos['preco_venda']);

            if ($resultado != '') {
                return $resultado;
            }
        }
    }

    public function gravaItensPayPal($id_pedido, $id_pessoa) {
        $produto = new produtos();
        $banco = new cPDO();

        $valida = $this->verificaItensPayPal($id_pedido, $id_pessoa);
        if ($valida == '') {
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

                $id_lances = $rowLances['id_lances'];
                $qtdLances = $rowLances['qtd'];

                if ($id_lances != '') {
                    $lance_pessoa = $banco->query("CALL gravalancePessoa('','" . $id_pessoa . "', '" . $id_lances . "', '" . $qtdLances . "', '" . $qtdLances . "', '" . $rowLances['preco_venda'] . "', '', '', 'P', 'C')")->fetch();
                    $lance_pedido = $banco->query("CALL gravalancePedido('" . $lance_pessoa["Msg"] . "', '" . $id_pedido . "')")->fetch();
                }

                $itens = $banco->query("CALL gravaItensPedido('" . $id_pedido . "', '" . $idProdutos . "', '" . $idPP . "', '" . $qtd . "')")->fetch();
            }
        } else {
            return $valida;
        }
    }

    public function precoTotalPayPal() {
        $produto = new produtos();
        $banco = new cPDO();
        $pagseguro = new pagseguro();

        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $produto->set(id_produtos, $id);
            $sql = $produto->ListaProdutos();
            $rowProdutos = $banco->query($sql)->fetch();
            $idPP = $rowProdutos['id_preco_produto'];
            $idProdutos = $rowProdutos['id_produtos'];
            $preco_total = ($preco_total + ($rowProdutos['preco_venda']) * $qtd);
        }
        return number_format($preco_total, 2);
    }

    public function calculaFretePayPal($tipo_servico, $cepOrigem, $cepDestino) {
        $produto = new produtos();
        $banco = new cPDO();
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

            $id_lances = $rowLances['id_lances'];
            $qtdLances = $rowLances['qtd'];


            $peso = number_format($rowProdutos['peso'], 0);
            $altura = number_format($rowProdutos['altura'], 0);
            $largura = number_format($rowProdutos['largura'], 0);
            $comprimento = number_format($rowProdutos['comprimento'], 0);


            if ($id_lances == 0) {
                $valorFrete = calculaFrete($tipo_servico, $cepOrigem, $cepDestino, $peso, $altura, $largura, $comprimento, "0");
                $valorFreteTotal += (($valorFrete) * $qtd) + 0.95;
            }
        }
        return number_format($valorFreteTotal, 2);
    }

    public function redirecionaPayPal($resposta, $token) {
        if (isset($resposta) && $resposta == 'Success') {
            $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
            $query = array(
                'cmd' => '_express-checkout',
                'token' => $token
            );
            echo "<script type=\"text/javascript\">__url('" . $paypalURL . "?" . http_build_query($query) . "');</script>";
        } else {
            echo 'Falha na transação';
        }
    }

    public function validaDadosCadastrais($cepDestino, $cepOrigem, $nome, $email, $ddd, $tel, $cpf, $senhaP, $usuarioP, $tokenP) {
        if (($cepDestino == '') || (strlen($cepDestino) != '8')) {
            return 'CEP de destino inválido, verifique o CEP informado no cadastro!';
        }
        if (($cepOrigem == '') || (strlen($cepOrigem) != 8)) {
            return 'CEP de origem inválido, entre em contato com a empresa!';
        }
        if ($senhaP == '') {
            return 'Senha do paypal não informada, entre em contato com a empresa!';
        }
        if ($usuarioP == '') {
            return 'Usuário do paypal não informado, entre em contato com a empresa!';
        }
        if ($tokenP == '') {
            return 'Token não informado, entre em contato com a empresa!';
        }
        if ($nome == '') {
            return 'Nome do cliente não informado, verifique o cadastro!';
        }
        if (strlen($nome) <= 12) {
            return 'Nome inferior a 12 caracteres, verifique o cadastro!';
        }
        if ($email == '') {
            return 'Email não informado, verifique o cadastro!';
        }
        if ($ddd == '') {
            return 'DDD não informado, verifique o cadastro!';
        }
        if ($tel == '') {
            return 'Telefone não informado, verifique o cadastro!';
        }
        if ($cpf == '') {
            return 'CPF não informado, verifique o cadastro!';
        }
        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            if ($qtd == 0) {
                return 'Produto com quantidade zero!';
            }
        }
        return '';
    }

    public function validaItensPayPal($id_produto, $qtd_estoque, $nome, $id_preco, $id_lances, $id_pessoa, $id_pedido, $preco) {
        if ($id_pedido <= 0) {
            return 'Código do pedido não encontrado!';
        }
        if ($nome == '') {
            return 'Nome do produto não encontrado!';
        }
        if ($id_produto <= 0) {
            $msg = 'Código do produto "' . $nome . '" não encontrado!';
            return $msg;
        }
        if ($id_preco <= 0) {
            $msg = 'Preço do produto "' . $nome . '" não cadastrado!';
            return $msg;
        }
        if ($preco <= 0) {
            $msg = 'Preço de venda do produto "' . $nome . '" não cadastrado!';
            return $msg;
        }
        if ($qtd_estoque <= 0) {
            $msg = 'Produto "' . $nome . '" com quantidade insuficiente em estoque!';
            return $msg;
        }
        if ($id_lances > 0) {
            if ($id_pessoa <= 0) {
                return 'Código da pessoa não encontrado!';
            }
        }
        return '';
    }

}

?>
