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

// FUNCAO PARA MINUATURA
	// A VARIAVEL DIRECT SERVE PARA BUSCAR AS IMAGENS EM UMA PASTA (DIFERENTE DA PASTA PADRAO)
	// A VARIAVEL GRUPO SERVE PARA AGRUPAR AS IMAGENS COMO NUMA GALERIA	
	// A VARIAVEL LINK DETERMINA SE EU VOU ABRIR UMA IMAGEM OU UM POST
	function getThumb($img, $title, $alt, $w, $h, $group = NULL, $direct = NULL, $link = NULL ){
		// CONFIGURACAO DA GALERIA POR DIRETORIO
		$direct = ($direct != NULL ? "$direct" : "uploads");
		// CONFIGURACAO DA GALERIA
		$group = ($group != NULL ? "[$group]" : "");
		// DEVEMOS VERIFICAR O DIRETORIO PARA CHECAR SE E POST OU IMAGEM
		$dirLink = explode('/',$_SERVER['PHP_SELF']);
		// E NECESSARIO VERIFICAR SE ESTAMOS NO BACK OU NO FRONT, PARA ISSO CRIAMOS UM ARRAY
		$dirUrl = (in_array('admin', $dirLink) ? '../' : '');
		// APOS ISSO DEVEMOS VERIFICAR SE A IMAGEM JA EXISTE
		if (file_exists($dirUrl.$direct.'/'.$img)) {
			// QUANDO O LINK FOR NULO, IREMO ATRIBUI O LINK PARA A PROPRIA IMAGEM
			if ($link == '') {
				echo '<a href="'.BASE.'/'.$direct.'/'.$img.'" rel="shadowbox'.$group.'" title="'.$title.'">
							<img src="'.BASE.'/th.php?src='.BASE.'/'.$direct.'/'.$img.'&w='.$w.'&h='.$h.'&zc=1&q=100" 
								title="'.$title.'" alt="'.$alt.'" />
					  </a>';
		    // AQUI CRIAMOS UM LINK CEGO
			}elseif ($link == '#') {
				echo '<img src="'.BASE.'/th.php?src='.BASE.'/'.$direct.'/'.$img.'&w='.$w.'&h='.$h.'&zc=1&q=100" 
								title="'.$title.'" alt="'.$alt.'" />';
			// SE O LINK NAO VOLTAR COM A IMAGEM OU COM A # ELE DEVE VOLTAR COM ALGUM VALOR
			}else{
				echo '<a href="'.$link.'" title="'.$title.'">
							<img src="'.BASE.'/th.php?src='.BASE.'/'.$direct.'/'.$img.'&w='.$w.'&h='.$h.'&zc=1&q=100" 
								title="'.$title.'" alt="'.$alt.'" />
					  </a>';
			}
		}else{
			// SE A IMAGEM NAO EXISTIR, PODEMOS INFORMAR UMA IMAGEM PADRAO
			echo '<img src="'.BASE.'/th.php?src='.BASE.'/imgs/default.gif&w='.$w.'&h='.$h.'&zc=1&q=100" 
								title="'.$title.'" alt="'.$alt.'" />';
		}		
	}

	getThumb('01.jpg', 'Image1', 'Image1', '360', '180', '', '', 'http://www.raloliver.com.br');
	getThumb('02.jpg', 'Image2', 'Image1', '360', '180', '', '', '#');
	getThumb('03.jpg', 'Image3', 'Image1', '360', '180', '', '', '');
	getThumb('17.jpg', 'Default', 'Default', '200', '200', '', '', '');
 ?>