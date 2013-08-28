<?php

class estado extends database {

    private $id_estado;
    private $desc_uf;
    private $uf;

//Método para atribuir valores às propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    public function ListaUf() {
        $sql = "SELECT e.* FROM estado e ORDER BY uf ASC";
        return $sql;
    }
    public function ListaUfId() {
        if ($this->id_estado != '') {
            $id_estado = " WHERE e.id_estado = '$this->id_estado'";
        }
        
        $sql = "SELECT e.* FROM estado e $id_estado";
        return $sql;
    }
	
}

?>
