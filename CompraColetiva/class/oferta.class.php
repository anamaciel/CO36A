<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of oferta
 *
 * @author AnaaMaciel
 */
class oferta{

    private $id;
    private $nome;
    private $descricao;
    private $data_inicio;
    private $data_fim;
    private $qtd_minima;
    private $qtd_vendida;
    private $valor_real;
    private $valor_liquido;

    function set($prop, $value) {
        $this->$prop = $value;
    }

    function verificaNull($value) {
        if ($value != '') {
            return "'" . $value . "'";
        } else {
            return "NULL";
        }
    }

    public function ListaOferta() {
        if ($this->id != '') {
            $id = " AND o.id = '$this->id'";
        }
        if ($this->nome != '') {
            $nome = " AND o.nome = '$this->nome'";
        }
        if ($this->descricao != '') {
            $descricao = " AND o.descricao = '$this->descricao'";
        }
        if ($this->data_inicio != '') {
            $data_inicio = " AND o.data_inicio = '$this->data_inicio'";
        }
        if ($this->data_fim != '') {
            $data_fim = " AND o.data_fim = '$this->data_fim'";
        }
        if ($this->qtd_minima != '') {
            $qtd_minima = " AND o.qtd_minima = '$this->qtd_minima'";
        }
        if ($this->qtd_vendida != '') {
            $qtd_vendida = " AND o.qtd_vendida = '$this->qtd_vendida'";
        }
        if ($this->valor_real != '') {
            $valor_real = " AND o.valor_real = '$this->valor_real'";
        }
        if ($this->valor_liquido != '') {
            $valor_liquido = " AND o.valor_liquido = '$this->valor_liquido'";
        }

        $sql = "SELECT o.*, DATE_FORMAT(o.data_inicio, '%d/%m/%Y hh:mm:ss') as data_inicioF, DATE_FORMAT(o.data_fim, '%d/%m/%Y hh:mm:ss') as data_fimF
                FROM oferta o
                WHERE id>0 $id $nome $descricao $data_inicio $data_fim $qtd_minima $qtd_vendida $valor_real $valor_liquido
                ORDER BY o.data_inicio DESC;";
        return $sql;
    }

    public function GravaOferta() {
        if ($this->id > 0) {
            if ($this->nome != '') {
                $nome = " nome = '$this->nome'";
            }
            if ($this->descricao != '') {
                $descricao = " ,descricao = '$this->descricao'";
            }
            if ($this->data_inicio != '') {
                $data_inicio = " ,data_inicio = '$this->data_inicio'";
            }
            if ($this->data_fim != '') {
                $data_fim = " ,data_fim = '$this->data_fim'";
            }
            if ($this->qtd_minima != '') {
                $qtd_minima = " ,qtd_minima = '$this->qtd_minima'";
            }
            if ($this->qtd_vendida != '') {
                $qtd_vendida = " ,qtd_vendida = '$this->qtd_vendida'";
            }
            if ($this->valor_real != '') {
                $valor_real = " ,valor_real = '$this->valor_real'";
            }
            if ($this->valor_liquido != '') {
                $valor_liquido = " ,valor_liquido = '$this->valor_liquido'";
            }

            $sql = "UPDATE oferta SET $nome $descricao $data_inicio $data_fim $qtd_minima $qtd_vendida $valor_real $valor_liquido WHERE id='$this->id' LIMIT 1";
            return $sql;
        } else {
            $sql = "INSERT INTO oferta (id, nome, descricao, data_inicio, data_fim, qtd_minima, qtd_vendida, valor_real, valor_liquido)
            VALUES ('', '$this->nome', '$this->descricao', '$this->data_inicio', '$this->data_fim', '$this->qtd_minima', '$this->qtd_vendida', '$this->valor_real', '$this->valor_liquido')";
        }
        return $sql;
    }

}

?>
