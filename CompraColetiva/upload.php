<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("class/funcoes.php");
require_once("class/pdo.class.php");

$id_oferta = $_POST['id'];
$foto = $_FILES['foto'];

//echo $foto;

$uploaddir = 'ofertas/';
$uploadfile = $uploaddir . $_FILES['foto']['name'];
print "<pre>";
if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $id_oferta . '.jpg')) {
    print "O arquivo é valido e foi carregado com sucesso. Aqui esta alguma informação:\n";
    print_r($_FILES);
}

$banco = new cPDO();

$sql = "INSERT INTO recursos VALUES ('', '$id_oferta', 'foto oferta', 'oferta', 'ofertas/$id_oferta.jpg')";
$banco->query($sql);

?>
