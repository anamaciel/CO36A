<?php

require_once("PagSeguroLibrary.php");

class pagseguro {

    public $produto;
    public $valor;
    public $item;
    public $quantidade;
    public $referencia;
    public $frete;
    public $cep;
    public $endereco;
    public $nr;
    public $complemento;
    public $bairro;
    public $cidade;
    public $uf;
    public $cliente;
    public $email;
    public $ddd;
    public $telefone;
    public $emailP;
    public $tokenP;
    public $url;
    var $link;

    function set($prop, $value) {
        $this->$prop = $value;
    }

    public function __construct() {
        $this->link = new PagSeguroPaymentRequest();
        $this->link->setCurrency("BRL");
    }
    
    public function addProduto(){
        $this->set(item, $this->item+1);
        $this->link->addItem($this->item, $this->produto, $this->quantidade, $this->valor);
    }

    public function geraUrl() {

        $this->link->setReference($this->referencia);

        // Sets shipping information for this payment request
        if ($this->frete == 'SEDEX') {
            $CODIGO_SEDEX = PagSeguroShippingType::getCodeByType('SEDEX');
            $this->link->setShippingType($CODIGO_SEDEX);
        } else {
            $this->link->setShippingType($this->frete);
        }
        $this->link->setShippingAddress($this->cep, $this->endereco, $this->nr, $this->complemento, $this->bairro, $this->cidade, $this->uf, 'BRA');

        // Sets your customer information.
        $this->link->setSender($this->cliente, $this->email, $this->ddd, $this->telefone);

        $this->link->setRedirectUrl("http://games.fanaticosporcompras.com.br/pagseguro/retorno.php");

        try {
            $credentials = new PagSeguroAccountCredentials($this->emailP, $this->tokenP);

            $url = $this->link->register($credentials);
            
            $url = explode("?code=", $url);

            //echo "<p><a title=\"URL do pagamento\" href=\"$url\">Ir para URL do pagamento.</a></p>";
            return $url['1'];
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }

}

?>