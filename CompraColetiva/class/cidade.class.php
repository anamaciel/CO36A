<?php

class cidade extends database {

    private $id;
    private $id_estado;
    private $desc_cidade;
    private $cod_sinp;
    private $cod_siafi;
    private $cod_dv;

//Método para atribuir valores às propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    public function ListaCidadeUf() {
        $sql = "SELECT c.* FROM cidade c WHERE c.id_estado='$this->id_estado' ORDER BY c.desc_cidade ASC";
        return $sql;
    }
    
    public function ListaCidadeId() {
        if ($this->id != '') {
            $id = " WHERE c.id_cidade = '$this->id'";
        }
        $sql = "SELECT c.* FROM cidade c $id LIMIT 1";
        return $sql;
    }
}

?>
