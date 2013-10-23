<?php 
	require('config.php'); // O IDEAL E UTILIZAR O require POIS O include_once TENDE A DEIXAR A APLICACAO MAIS LENTA
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<link href="assets/css/bootstrap.min.css" rel="stylesheet">';
	echo '<link href="assets/css/plan.min.css" rel="stylesheet">';
	echo '<link href="http://fonts.googleapis.com/css?family=Lato:300,700,300italic" rel="stylesheet">';


	//ACAO PARA DELETAR
	if (!empty($_GET['del'])) {
		//PARA QUE SEJA DELETADO O ITEM, SERA NECESSARIO CRIAR UMA VARIAVEL
		$del_item		= mysql_real_escape_string($_GET['del']);
		$del_query 		= "DELETE FROM rows_articles WHERE id = '$del_item'";
		$delex_query	= mysql_query($del_query) or die(mysql_error());
		//AVISO PARA INFORMAR QUE O ITEM FOI DELETADO
		if ($delex_query) {
			echo '<div class="span12 alert alert-error">
					<strong>Aviso!</strong> Item excluído com sucesso.
				  </div>';
		}
	}

	//SELECT=Seleciona colunas //FROM=Seleciona tabela //WHERE=Seleciona campo //GROUP BY=Agrupa //ORDER BY=Ordena
	//LIMIT=Limita a exibição //OFFSET=Remove o último da lista
	$cons_query = "SELECT * FROM rows_articles WHERE id !='' GROUP BY id ORDER BY date DESC LIMIT 20 OFFSET 0";
	$exec_query = mysql_query($cons_query) or die(mysql_error());	


	//EXIBIR ITEM
	if (!empty($_GET['id'])) {

		//PARA EXIBIR O ITEM, E NECESSARIO UTILIZAR A QUERY E CRIAR UMA NOVA VARIAVEL PARA O ITEM
		$id_item	= mysql_real_escape_string($_GET['id']);		
		$cons_item 	= "SELECT * FROM rows_articles WHERE id = '$id_item' ";
		$exec_item 	= mysql_query($cons_item) or die(mysql_error());
		//NESTE CASO NAO E NECESSARIO O LOOPING, POIS IREMOS BUSCAR APENAS UM VALOR
		$read_item	= mysql_fetch_assoc($exec_item);

		echo '<div class="container">';
		echo '<div class="row">';
		echo '<div class="span12">';
		echo '<form class="form-horizontal"><fieldset>';
		echo '<legend>'.$read_item['title'].'</legend>';
		echo '<p>'.$read_item['content'].'</p>';
		echo '<p><strong>'.date('d/m/Y H:i',strtotime($read_item['date'])).'</strong></p>';
		echo '<a href="read.php" class="btn btn-warning"> Voltar </a>';
		echo '</fieldset></form>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	//CONTAR RESULTADOS
	echo '<div class="container">';
	echo '<div class="row">';
	echo '<div class="span12">';
	echo '<p class="lead muted">Existem '.mysql_num_rows($exec_query).' posts cadastrados em uma tabela com ';
	echo mysql_num_fields($exec_query).' colunas.</p>';

	// VERIFICAR O RETORNO DOS RESULTADOS
	if (mysql_num_rows($exec_query) <= 0) {
		echo 'Dados não encontrados';
	}else{
	// LOOPING DE RESULTADOS
		echo '<table class="table table-bordered table-striped">';
		while ($resu_query = mysql_fetch_array($exec_query)) {
	// TUDO QUE FOR INCLUIDO AQUI VAI SER REPETIDO BASEADO NOS RESULTADOS DA QUERY
			echo '<tbody>';
				echo '<tr>';
					echo '<td><a href="read.php?id='.$resu_query['id'].'">'.$resu_query['title'].'</a></td>';
					echo '<td><a href="edit.php?id='.$resu_query['id'].'" class="btn btn-warning" ><i class="icon-edit"></i> Editar</a></td>';
					echo '<td><a href="read.php?del='.$resu_query['id'].'" class="btn btn-danger" ><i class="icon-remove"></i> Excluir</a></td>';
				echo '</tr>';
			echo '</tbody>';
	// DEBUG
	//	echo '<pre>';
	//	while ($resu_query = mysql_fetch_assoc($exec_query)) { // USAMOS o mysql_fetch_assoc PARA RETORNAR APENAS O VALOR SEM O INDICE
	//		print_r ($resu_query);
		}
		echo '</table>';	
	}
	echo '</div>';
	echo '</div>';
	echo '</div>';
?>

