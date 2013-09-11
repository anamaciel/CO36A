<?php

class cidade extends database {

    private $id;
    private $estado;
    private $uf;
    private $nome;

//M�todo para atribuir valores �s propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    public function ListaCidadeUf() {
        $sql = "SELECT c.* FROM cidade c WHERE c.estado='$this->estado' ORDER BY c.nome ASC";
        return $sql;
    }
    
    public function ListaCidadeId() {
        if ($this->id != '') {
            $id = " WHERE c.id = '$this->id'";
        }
        $sql = "SELECT c.* FROM cidade c $id LIMIT 1";
        return $sql;
    }
}

?>
