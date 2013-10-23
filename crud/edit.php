<?php 
	require('config.php'); // O IDEAL E UTILIZAR O require POIS O include_once TENDE A DEIXAR A APLICACAO MAIS LENTA
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<link href="assets/css/bootstrap.min.css" rel="stylesheet">';
	echo '<link href="assets/css/plan.min.css" rel="stylesheet">';
	echo '<link href="http://fonts.googleapis.com/css?family=Lato:300,700,300italic" rel="stylesheet">';

	//VARIAVEL NECESSARIA PARA QUE ATUALIZAR SEJA FEITA DE MANEIRA INDIVIDUAL
	$acc_id		= mysql_real_escape_string($_GET['id']);
	if (isset($_POST['sendform'])) {
		// VARIAVEIS DE VALOR QUE DEVEM SER INSERIDAS NO BD

		#$acc['title'] = $_POST['title']; // METODO MAIS ANTIGO E COMUM, POREM INSEGURO

		$acc['title'] 	= htmlspecialchars(mysql_real_escape_string($_POST['title'])); // MANEIRA MAIS SEGURA COM ADICAO DA \ POREM O htmlspecialchars CONVERTE ISSO PARA UMA MELHOR LEITURA
		$acc['content'] = htmlspecialchars(mysql_real_escape_string($_POST['content']));
		$acc['date'] 	= htmlspecialchars(mysql_real_escape_string($_POST['date']));

		//A ATUALIZACAO DEVE SEMPRE SER FEITA ACIMA DO SELECT
		$acc_query	= "UPDATE rows_articles SET title = '$acc[title]', content= '$acc[content]', date= '$acc[date]' WHERE id ='$acc_id'"; //AO EXECUTAR UM UPDATE, LEMBRE-SE SEMPRE DO WHERE
		$acc_exe 	= mysql_query($acc_query) or die (mysql_errno());

		if ($acc_exe) {
			echo '<div class="span12 alert alert-success">
					<strong>Aviso!</strong> Item atualizado com sucesso.
				  </div>';	
		}
		
		echo '<hr/>'; // AGORA É NECESSÁRIO INFORMAR O VALOR DE ACORDO COM O ID QUE SERA INFORMADO PARA APENAS ATUALIAZAR O BANCO
	}

		//SEMPRE FACA A ATUALIZACAO ACIMA DO SELECT
		$acc_cons 	= "SELECT * FROM rows_articles WHERE id ='$acc_id'";
		$acc_exec 	= mysql_query($acc_cons) or die(mysql_error());
		//SE FOR INFORMADOR UM ID QUE NAO EXISTE, O USUARIO SERA REDIRECIONADO PARA A PAGINA DE LEITURA DO ITEM
		if (mysql_num_rows($acc_exec) <= 0) {
			header('Location: read.php');
		}

		//COMO SER REATORNADO APENAS UM ITEM, O LOOPING NAO E NECESSARIO
		$acc_res 	= mysql_fetch_assoc($acc_exec);
echo 
	'<div class="container">
		<div class="row">
			<div class="span12">
				<form name="acc_create" action="" method="post">
					<legend class="lead muted">Editar</legend>
					<fieldset>
						<label>
							<span>Título:</span><br>
							<input type="text" name="title" value="'.$acc_res['title'].'"> 
						</label>
						<label>
							<span>Conteúdo:</span><br>
							<textarea name="content" rows="3">'.$acc_res['content'].'</textarea>
						</label>
						<label>
							<span>Criação:</span><br>
							<input type="text" name="date" value="'.$acc_res['date'].'"> 
						</label>
						<input class="btn btn-primary" type="submit" value="Atualizar" name="sendform"> <a href="read.php" class="btn btn-warning"> Voltar </a>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
	';
?>