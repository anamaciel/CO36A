<?php

class login extends database {

    public $id;
    public $email;
    public $senha;

    public function set($prop, $value) {
        $this->$prop = $value;
    }

    public function Logar() {
        $sql = "SELECT u.* FROM usuario u WHERE u.email='$this->email' AND u.senha='$this->senha' ORDER BY u.nome ASC";
        return $sql;
    }

}

?>
