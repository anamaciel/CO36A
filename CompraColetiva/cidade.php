<?php
require_once('class/mysql.class.php');
require_once('class/cidade.class.php');

$estado = $_POST['uf'];

echo $estado;

$cidade = new cidade();
$cidade->set(estado, $estado);
$sql = $cidade->ListaCidadeUf();
echo $sql;

$banco = new database();
$banco->connect();
$banco->sqlQuery($sql);
if($banco->num_rows() == 0){
   echo  '<option value="0">'.htmlentities('Nenhuma cidade encontrada').'</option>';
   
}else{
   while($ln = $banco->fetch_assoc()){
      echo '<option value="'.htmlentities($ln['id']).'">'.htmlentities($ln['nome']).'</option>';
   }
}

?>