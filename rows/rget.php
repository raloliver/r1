<?php 
// FUNCAO PARA PERSONALIZACAO DE URL (SLUG)
	function getHome(){
		$url = $_GET['url'];
		$url = explode('/', $url);
		$url[0] = ($url[0] == NULL ? 'index' : $url[0]);
			if(file_exists('theme/'.$url[0].'.php')){
				require_once('theme/'.$url[0].'.php');
			}elseif(file_exists('theme/'.$url[0].'/'.$url[1].'.php')){
				require_once('theme/'.$url[0].'/'.$url[1].'.php');
			}else{
				require_once('theme/404.php');	
			}
	}
 ?>