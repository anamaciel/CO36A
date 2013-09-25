<?php

class usuario {

    public $id;
    public $endereco_id;
    public $nome;
    public $sobrenome;
    public $sexo;
    public $nascimento;
    public $login;
    public $senha;
    public $tipo;

    //M�todo para atribuir valores �s propriedades da classe.
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

    public function ListaUsuario() {
        if ($this->id != '') {
            $id = " AND id='$this->id' ";
        }
        if ($this->nome != '') {
            $nome = " AND nome='$this->nome' ";
        }
        if ($this->sobrenome != '') {
            $sobrenome = " AND sobrenome='$this->sobrenome' ";
        }
        if ($this->sexo != '') {
            $sexo = " AND sexo='$this->sexo' ";
        }
        if ($this->nascimento != '') {
            $nascimento = " AND nascimento='$this->nascimento' ";
        }
        if ($this->login != '') {
            $login = " AND login='$this->login' ";
        }
        if ($this->senha != '') {
            $senha = " AND senha='$this->senha' ";
        }
        if ($this->tipo != '') {
            $tipo = " AND tipo='$this->tipo' ";
        }

        $sql = "SELECT * FROM usuario u WHERE u.id > 0 $nome $sobrenome $sexo $nascimento $login $senha $tipo ORDER BY nome ASC;";
        return $sql;
    }

    public function GravaUsuario() {
        if ($this->id > 0) {
            if ($this->nome != '') {
                $nome = ", nome='$this->nome' ";
            }
            if ($this->sobrenome != '') {
                $sobrenome = ", sobrenome='$this->sobrenome' ";
            }
            if ($this->sexo != '') {
                $sexo = ", sexo='$this->sexo' ";
            }
            if ($this->nascimento != '') {
                $nascimento = ", nascimento='$this->nascimento' ";
            }
            if ($this->login != '') {
                $login = ", login='$this->login' ";
            }
            if ($this->senha != '') {
                $senha = ", senha='$this->senha' ";
            }
            if ($this->tipo != '') {
                $tipo = ", tipo='$this->tipo' ";
            }

            $sql = "UPDATE usuario SET $nome $sobrenome $sexo $nascimento $login $senha $tipo WHERE id='$this->id' LIMIT 1";
            return $sql;
        } else {
            $sql = "INSERT INTO usuario (id, nome, sobrenome, sexo, nascimento, login, senha, tipo)
            VALUES ('', '$this->nome', '$this->sobrenome', '$this->sexo', '$this->nascimento', '$this->login', '$this->senha', '$this->tipo')";
        }
        return $sql;
    }

}

?>