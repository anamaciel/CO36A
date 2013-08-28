<?php

class bairros extends database {

    private $id_bairros;
    private $id_cidade;
    private $bairro;
    private $foto;
    private $descricao;

//Método para atribuir valores às propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    public function ListaBairros() {
        if ($this->id_bairros != '') {
            $id_bairros = " AND b.id_bairros = '$this->id_bairros'";
        }
        if ($this->bairro != '') {
            $bairro = " AND b.bairro = '$this->bairro'";
        }
        
        $sql = "SELECT b.* FROM bairros b WHERE b.id_bairros > 0 $id_bairros $bairro ORDER BY b.bairro ASC";
        return $sql;
    }

}

?>