<?php 
// PAGINACAO
	// INDICE DA PAGINACAO
	$pag = (!$url['2'] ? '1' : $url['2']);
	// REGRAS DE PAGINACAO
	$pagMax = 3; // AQUI DETERMINA O MAXIMO POR PAGINA
	$pagBeg = ($pag * $pagMax) - $pagMax;
	$readArt = read('rows_articles',"LIMIT $pagBeg,$pagMax");

// DEBUG	
	echo '<ul>';
		foreach ($readArt as $art):
			echo '<li>'.$art['title'].'</li>';
		endforeach;
	echo '</ul>';

	$link = BASE.'/index/page/';
	pagination('rows_articles', "", $pagMax, $link, $pag, 'span3');

 ?>