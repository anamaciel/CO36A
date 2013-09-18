<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("caminho.php");

unset($_SESSION['id']);
unset($_SESSION['nome']);
unset($_SESSION['email']);

echo"
	<script language=\"javascript\">
	location.href=\"" . $caminho. "site/\"
	</script>
";
?>