<?php

if ($_SESSION['id'] == '') {
    
    echo "<script language=\"javascript\">location.href=\"" . $caminho. "site/login\"</script>";
    
} else {
    ?>
<p>Minha conta</p>

<ul>
    <li>Dados Pessoais</li>
    <li>Endereço</li>
    <li>Minhas Compras</li>
    <li>Minhas Ofertas</li>
</ul>
    
    
<?php
}
?>
