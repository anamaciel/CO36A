<?php

if (!isset($_SESSION)) {
    session_start();
}

class endereco extends database {

    private $id_endereco;
    private $id_pessoa;
    private $id_filial;
    private $cidade_id;
    private $cep;
    private $endereco;
    private $nr;
    private $bairro;
    private $complemento;
    private $tipo;

//Método para atribuir valores ?s propriedades da classe.
    function set($prop, $value) {
        $this->$prop = $value;
    }

    //Método para verificar se o valor que est?o vindo vazio para campos NULL.
    function verificaNull($value) {
        if ($value != '') {
            return "'" . $value . "'";
        } else {
            return "NULL";
        }
    }

    public function ListaEndereco() {
        if ($this->id_pessoa > 0) {
            $id_pessoa = " AND e.id_pessoa = '$this->id_pessoa'";
        }
        if ($this->id_endereco > 0) {
            $id_endereco = " AND e.id_endereco = '$this->id_endereco'";
        }
        $sql = "SELECT e.*, c.desc_cidade, et.uf FROM endereco e, cidade c, estado et WHERE e.id_endereco <> '0' AND c.id_cidade = e.cidade_id AND et.id_estado = c.id_estado $id_pessoa $id_endereco";
        return $sql;
    }
    
    public function ListaEnderecoFilial() {
        if ($this->id_filial > 0) {
            $id_filial = " AND f.id_filial = '$this->id_filial'";
        }
        $sql = "SELECT f.*, e.*, p.* FROM filial f, endereco e, pessoa p WHERE f.id_pessoa = p.id_pessoa AND
                e.id_pessoa = f.id_pessoa $id_filial";
        return $sql;
    }
    
    
    public function ListaEnderecoPorId() {
        if ($this->id_endereco > 0) {
            $id_endereco = " AND e.id_endereco = '$this->id_endereco'";
        }
        $sql = "SELECT e.*, c.desc_cidade, et.uf FROM endereco e, cidade c, estado et WHERE e.id_endereco <> '0' AND c.id_cidade = e.cidade_id AND et.id_estado = c.id_estado $id_endereco";
        return $sql;
    }
    
    public function GravaEndereco() {
        if ($this->id_endereco > 0) {
            $sql = "UPDATE endereco SET cidade_id='$this->cidade_id', cep=" . $this->verificaNull(tiraTudo($this->cep)) . ", endereco=" . $this->verificaNull(utf8_decode($this->endereco)) . ", nr=" . $this->verificaNull(utf8_decode($this->nr)) . ", bairro=" . $this->verificaNull(utf8_decode($this->bairro)) . ", complemento=" . $this->verificaNull(utf8_decode($this->complemento)) . ", tipo=" . $this->verificaNull($this->tipo) . " WHERE id_endereco='$this->id_endereco' LIMIT 1";
            return $sql;
        } else {
            $sql = "INSERT INTO endereco (id_endereco, id_pessoa, cidade_id, cep, endereco, nr, bairro, complemento, tipo)
            VALUES ('', '$this->id_pessoa', '$this->cidade_id', " . $this->verificaNull(tiraTudo($this->cep)) . ", " . $this->verificaNull(utf8_decode($this->endereco)) . ", " . $this->verificaNull(utf8_decode($this->nr)) . ", " . $this->verificaNull(utf8_decode($this->bairro)) . ", " . $this->verificaNull(utf8_decode($this->complemento)). ", " . $this->verificaNull($this->tipo) . ")";
        }
        return $sql;
    }
    
    public function ExcluiEndereco() {
        if ($this->id_endereco != '') {
            $id_endereco = "WHERE id_endereco = '$this->id_endereco'";
        }
        $sql = "DELETE FROM endereco $id_endereco";
        return $sql;
    }

}

?>
