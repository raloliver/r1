<?php 
// SET HOME

	function setHome(){
		echo BASE;
	}


// URL AMIGAVEL

	function setAlias ($string) {
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
		//O FORMATO PARA INSERIR NO BANCO ESTA CORRETO, POREM E PRECISO DECODIFICAR PARA QUE A VISUALIZACAO TAMBEM SEJA CORRIGIDA
		$string = utf8_decode($string);
		// O STRTR PEDE UMA FONTE DA ONDE OS DADOS VEEM E PEDE UM SEGUNDA FONTE PARA COMPARAR E SUBSTITUIR POR UM TERCEIRA FONTE. utf8_decode PARA LER OS CARACTERES
		$string = strtr($string, utf8_decode($a), $b);
		// AGORA DEVEMOS UTILIZAR O strip_tags E O trim POIS CASO EXISTA ALGUM CARACTER EM FORMA DE CODIGO, ELE VAI REMOVER (strip_tags) E O trim VAI REMOVER O ESPACAMENTO
		$string = strip_tags(trim($string));
		// REPLACE NOS ESPACOS, TROCANDO POR TRACOS
		$string = str_replace(" ", "-", $string);
		// TRANSFORMAR VARIOS ESPACOS EM APENAS UM
		// O MAXIMO QUE O TRIM REMOVE SAO 5 ESPACOS
		$string = str_replace(array("-----","----","---","--"), "-", $string);
		// CONVERTER PARA LETRAS MINUSCULAS
		// UTILIZAMOS O RETURN PARA ARMEZAR O RETORNO DESSE FUNCAO NO BD
		return strtolower(utf8_encode($string));
	}
 ?>