<?php

require_once(dirname(__FILE__) . '/funcoes.php');

define('VM_FETCH_ARRAY', 'array');
define('VM_FETCH_ASSOC', 'assoc');
define('VM_FETCH_OBJECT', 'object');
define('VM_FETCH_ROW', 'row');

class database {

    var $link;
    var $host;
    var $db;
    var $user;
    var $password;
    var $_query_id;

// Local
    public function __construct() {
        $this->host = 'localhost';
        $this->db = 'compracoletiva';
        $this->user = 'root';
        $this->password = '';
    }

    function connect() {
        @$this->link = mysql_connect($this->host, $this->user, $this->password);
        $this->select_db();
    }

    function select_db() {
        return @mysql_select_db($this->db, $this->link) or die("Nao foi possivel selecionar o banco de dados.");
    }

    function close() {
        return mysql_close($this->link);
    }

    function sqlQuery($sql) {
        $this->_query_id = mysql_query($sql);
        return $this->_query_id ? $this->_query_id :
                false;
    }

    function insert_id() {
        return mysql_insert_id($this->link);
    }

    function fetch_array($query_id = '') {
        $query_id = (!$query_id) ? $this->_query_id :
                $query_id;
        return mysql_fetch_array($query_id, MYSQL_ASSOC);
    }

    function fetch_row($query_id = '') {
        $query_id = (!$query_id) ? $this->_query_id :
                $query_id;
        return mysql_fetch_row($query_id);
    }

    function fetch_object($query_id = '') {
        $query_id = (!$query_id) ? $this->_query_id :
                $query_id;
        return mysql_fetch_object($query_id);
    }

    function fetch_assoc($query_id = '') {
        $query_id = (!$query_id) ? $this->_query_id :
                $query_id;
        return mysql_fetch_assoc($query_id);
    }

    function fetch_field($result, $offset = 0) {
        $result = !$result ? $this->_query_id :
                $result;
        return @mysql_fetch_field($result, $offset);
    }

    function num_rows($query_id = '') {
        $query_id = (!$query_id) ? $this->_query_id :
                $query_id;
        return mysql_num_rows($query_id);
    }

    function result($result = '', $row = 0, $cols = 0) {
        $result = !$result ? $this->_query_id :
                $result;
        return mysql_result($result, $row, $cols);
    }

    function num_fields($result = '') {
        $result = !$result ? $this->_query_id :
                $result;
        return mysql_num_fields($result);
    }

    function affected_rows() {
        return mysql_affected_rows($this->link);
    }

    function field_name($result = '', $i = 0) {
        $result = !$result ? $this->_query_id :
                $result;
        return mysql_field_name($result, $i);
    }

    function field_len($result = '', $i = 0) {
        $result = !$result ? $this->_query_id :
                $result;
        return mysql_field_len($result, $i);
    }

    function field_type($result = '', $i = 0) {
        $result = !$result ? $this->_query_id :
                $result;
        return mysql_field_type($result, $i);
    }

    function list_fields($table) {
        if (!is_string($table))
            return;
        return mysql_list_fields($this->db, $table, $this->link);
    }

    function start_transaction() {
        mysql_query("START TRANSACTION");
    }

    function commit() {
        mysql_query("COMMIT");
    }

    function rollback() {
        mysql_query("ROLLBACK");
    }

}

?>