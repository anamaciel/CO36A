<?php
if (!isset($_SESSION)) {
    session_start();
}
$id = anti_injection($id);

require_once("class/funcoes.php");
require_once("class/mysql.class.php");
require_once("class/usuario.class.php");
require_once("class/endereco.class.php");
require_once("class/oferta.class.php");
require_once("class/pdo.class.php");

?>
<div class="content">
        <div class="container_12">
            <form id="form" action="<?php echo $caminho; ?>upload/" method="post"  enctype="multipart/form-data">
                <div class="grid_12">
                    <h3>FOTO DA OFERTA</h3>
                    <fieldset>
                        <label class="name">
                            <input type="hidden" value="<?php echo $id; ?>" name="id" id="foto">
                            <input type="file" value="" name="foto" id="foto">
                            <br class="clear">
                            <div class="spaceLabel"></div>
                        </label>
                    </fieldset>
                </div>
                <input type="submit" value="Enviar">
            </form>
             <div class="clear"></div>
        </div>
</div>