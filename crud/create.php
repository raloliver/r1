<?php 
	require('config.php'); // O IDEAL E UTILIZAR O require POIS O include_once TENDE A DEIXAR A APLICACAO MAIS LENTA
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<link href="assets/css/bootstrap.min.css" rel="stylesheet">';
	echo '<link href="assets/css/plan.min.css" rel="stylesheet">';
	echo '<link href="http://fonts.googleapis.com/css?family=Lato:300,700,300italic" rel="stylesheet">';

	if (isset($_POST['sendform'])) {
		// VARIAVEIS DE VALOR QUE DEVEM SER INSERIDAS NO BD

		#$acc['title'] = $_POST['title']; // METODO MAIS ANTIGO E COMUM, POREM INSEGURO

		$acc['title'] 	= htmlspecialchars(mysql_real_escape_string($_POST['title'])); // MANEIRA MAIS SEGURA COM ADICAO DA \ POREM O htmlspecialchars CONVERTE ISSO PARA UMA MELHOR LEITURA
		$acc['content'] = htmlspecialchars(mysql_real_escape_string($_POST['content']));
		$acc['date'] 	= htmlspecialchars(mysql_real_escape_string($_POST['date']));
		
		$acc_query	= "INSERT INTO rows_articles (title,content,date) ";
		$acc_query .= "VALUES ('$acc[title]','$acc[content]','$acc[date]')"; // PARA SEPARAR VALORES, BASTA CONCATENAR, LEMBRE-SE SEMPRE DO ESPAÇAMENTO
		$acc_create = mysql_query($acc_query) or die ('Erro no cadastro: '.mysql_error()); // SINTAXE BASICA DE CADASTRO

		//DEBUG (Avisos)

		if ($acc) {
			echo '<div class="span12 alert alert-success">
					<strong>Aviso!</strong> Item enviado com sucesso.
				  </div>';
		}else{
			echo 'Ocorreu um erro.';
		}

		echo '<hr/>'; // ANTES DE EXECUTAR O CRUD VERIFICAR SE O MESMO ESTAO CORRETO
	}
?>
<div class="container">
	<div class="row">
		<div class="span12">
			<form name="acc_create" action="" method="post">
				<legend class="lead muted">Criar</legend>
				<fieldset>
					<label>
						<span>Título:</span><br>
						<input type="text" placeholder="Título" name="title"> 
					</label>
					<label>
						<span>Conteúdo:</span><br>
						<textarea name="content" placeholder="Conteúdo" rows="3"></textarea>
					</label>
					<label>
						<span>Criação:</span><br>
						<input type="text" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>"> 
					</label>
					<input type="submit" class="btn btn-success" value="Enviar" name="sendform">
				</fieldset>
			</form>
		</div>
	</div>
</div>