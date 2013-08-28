<?php

class cliente extends database {

    public $id_cliente;
    public $id_pessoa;
    public $id_sexo;
    public $id_filial;
    public $id_ramo_atividade;
    public $qtd_lance;
    public $status;

    //Método para atribuir valores às propriedades da classe.
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

    public function ListaCliente() {
        if ($this->status != '') {
            $status = "AND p.status = '$this->status'";
        }
        if ($this->id_cliente != '') {
            $id_cliente = "AND c.id_cliente = '$this->id_cliente'";
        }
        if ($this->id_pessoa != '') {
            $id_pessoa = "AND c.id_pessoa = '$this->id_pessoa'";
        }
        if ($this->id_sexo != '') {
            $id_sexo = "AND c.id_sexo = '$this->id_sexo'";
        }
        if ($this->id_filial != '') {
            $id_filial = "AND c.id_filial = '$this->id_filial'";
        }
        if ($this->id_ramo_atividade != '') {
            $id_ramo_atividade = "AND c.id_ramo_atividade = '$this->id_ramo_atividade'";
        }
        if ($this->id_sexo != '') {
            $qtd_lance = "AND c.qtd_lance = '$this->qtd_lance'";
        }

        $sql = "SELECT p.*, c.id_cliente, c.qtd_lance, c.id_filial, c.id_sexo, t.telefone, dc.email, l.login, l.senha, DATE_FORMAT(p.dt_aniversario, '%d/%m/%Y') as dt_aniversarioF
                FROM pessoa p, cliente c, telefone t, dados_complementar dc, login l
                WHERE c.id_pessoa = p.id_pessoa AND t.id_pessoa = p.id_pessoa AND dc.id_pessoa = p.id_pessoa AND l.id_pessoa = p.id_pessoa $id_cliente $id_pessoa $id_sexo $id_filial $id_ramo_atividade $qtd_lance $status
                ORDER BY p.nome ASC;";
        return $sql;
    }

    public function GravaCliente() {
        if ($this->id_cliente > 0) {
            if ($this->id_cliente != '') {
                $id_cliente = ", id_cliente='$this->id_cliente' ";
            }
            if ($this->id_pessoa != '') {
                $id_pessoa = ", id_pessoa='$this->id_pessoa' ";
            }
            if ($this->id_sexo != '') {
                $id_sexo = ", id_cliente='$this->id_cliente' ";
            }
            if ($this->id_filial != '') {
                $id_filial = ", id_filial='$this->id_filial' ";
            }
            if ($this->id_ramo_atividade != '') {
                $id_ramo_atividade = ", id_ramo_atividade='$this->id_ramo_atividade' ";
            }
            if ($this->qtd_lance != '') {
                $qtd_lance = ", qtd_lance='$this->qtd_lance' ";
            }

            $sql = "UPDATE cliente SET $id_pessoa $id_sexo $id_filial $id_ramo_atividade $id_qtdlance WHERE id_cliente='$this->id_cliente' LIMIT 1";
            return $sql;
        } else {
            $sql = "INSERT INTO cliente (id_cliente, id_pessoa, id_sexo, id_filial, id_ramo_atividade, qtd_lance)
            VALUES ('', '$this->id_pessoa', '$this->id_sexo', '$this->id_filial', '$this->id_ramo_atividade', '$this->qtd_lance')";
        }
        return $sql;
    }

    function buscaCepCliente($id_end) {

        $bancoEnd = new cPDO();
        $endereco = new endereco();
        $endereco->set(id_endereco, $id_end);
        $sqlEnd = $endereco->ListaEndereco();
        $bancoEnd->query($sqlEnd);
        $row = $bancoEnd->query($sqlEnd)->fetch();
        return $row['cep'];
    }

}

?>