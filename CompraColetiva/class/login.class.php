<?php

class login extends database {

    public $id;
    public $login;
    public $senha;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function Logar() {
        $sql = "SELECT u.* FROM usuario u WHERE u.login='$this->login' AND u.senha='$this->senha' ORDER BY u.nome ASC";
        return $sql;
    }

}

?>
