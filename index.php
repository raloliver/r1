<?php 
ob_start(); session_start();
// ACESSO SO ARQUIVO DE CONFIGURACAO
require('/rows/rdba.php');
require('/rows/rget.php');
require('/rows/rset.php');
require('/rows/rall.php');
 ?>

 <!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>SNews</title>
	</head>
		<body>
			<?php 
				getHome();
			?>			
		</body>
<!-- ARQUIVO QUE CARREGA TODOS OS JAVASCRIPTS DO SITE -->
<?php include ('js/rjs.php'); ob_end_flush(); ?>
</html>