<?php 
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
			getThumb('01.jpg', 'Image1', 'Image1', '360', '180', '', '', 'http://www.raloliver.com.br');
			getThumb('02.jpg', 'Image2', 'Image1', '360', '180', '', '', '#');
			getThumb('03.jpg', 'Image3', 'Image1', '360', '180', '', '', '');
			getThumb('17.jpg', 'Default', 'Default', '200', '200', '', '', ''); 
			?>
		</body>
<!-- ARQUIVO QUE CARREGA TODOS OS JAVASCRIPTS DO SITE -->
<?php include ('js/rjs.php');?>
</html>