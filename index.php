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
		<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0"> -->
		<!-- <meta charset="utf-8"> -->
		<!-- <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
	</head>
		<body>
			<?php 
				viewManager();
			?>			
		</body>
<!-- ARQUIVO QUE CARREGA TODOS OS JAVASCRIPTS DO SITE -->
<?php include ('js/rjs.php'); ob_end_flush(); ?>
</html>