<?php

if (!isset($_SESSION)) {
    session_start();
}

class endereco extends database {

    private $id_endereco;
    private $cidade_id;
    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $tp_endereco;
    private $usuario_id;

//M�todo para atribuir valores ?s propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    //M�todo para verificar se o valor que est?o vindo vazio para campos NULL.
    function verificaNull($value) {
        if ($value != '') {
            return "'" . $value . "'";
        } else {
            return "NULL";
        }
    }

    
    public function GravaEndereco() {
        if ($this->id_endereco > 0) {
            $sql = "UPDATE endereco SET cidade_id='$this->cidade_id', logradouro= '$this->logradouro', numero= '$this->numero', complemento= '$this->complemento', bairro= '$this->bairro', tp_endereco= '$this->tp_endereco' WHERE id_endereco='$this->id_endereco' LIMIT 1";
            return $sql;
        } else {
            $sql = "INSERT INTO endereco (id_endereco, cidade_id, logradouro, numero, complemento,  bairro, tp_endereco, usuario_id)
            VALUES ('', '$this->cidade_id', '$this->logradouro', '$this->numero', '$this->complemento', '$this->bairro', '$this->tp_endereco', '$this->usuario_id')";
        }
        return $sql;
    }
}

?>
