<?php

require_once(dirname(__FILE__) . '/funcoes.php');

class cPDO {

    var $host;
    var $db;
    var $user;
    var $password;
    var $link;

    public function __construct() {
        $this->host = 'localhost';
        $this->db = 'compracoletiva';
        $this->user = 'root';
        $this->password = '';
        $this->link = new PDO("mysql:host=$this->host;dbname=$this->db", "$this->user", "$this->password");
    }

    
    function query($sql) {
        return $this->link->query($sql);
    }

}

?>