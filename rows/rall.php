<?php 
// FUNCAO LEIA MAIS
	function ReadMore($string, $read_more = '100'){
		$string = strip_tags($string);
		$caract = strlen($string);

		if ($caract <= $read_more) {
			return $string;
		}else{
			$strpos = strrpos(substr($string,0,$read_more),' ');
			return substr($string,0,$strpos).'... Leia mais';
		}
	}
//VALIDACAO DE CPF
	function cpf_valid($cpf) 
	{
		// VERIFICAR LINK http://www.geradorcpf.com/algoritmo_do_cpf.htm
		$cpf = preg_replace('/[^0-9]/', '', $cpf); 		

		$cpf_digitoA = 0;
		$cpf_digitoB = 0;

		for ($i=0, $x = 10; $i <= 8 ; $i++, $x--) { 
		// ALINHAR COLUNAS E MULTIPLAR OS VALORES DE CADA COLUNA E DESCOBRIR O RESULTADO
			$cpf_digitoA += $cpf[$i] * $x;
		}
		for ($i=0, $x = 11; $i <= 9 ; $i++, $x--) { 
			//CORRECAO DE CARACTERES IGUAIS, EX: 111.111.111-11
			if (str_repeat($i, 11) == $cpf) {	
				return FALSE;
			}
			$cpf_digitoB += $cpf[$i] * $x;
		}

		$countA = (($cpf_digitoA%11) < 2) ? 0 : 11-($cpf_digitoA%11); // DIGITO VERIFICADOR A
		$countB = (($cpf_digitoB%11) < 2) ? 0 : 11-($cpf_digitoB%11); // DIGITO VERIFICADOR B

		if ($countA != $cpf[9] || $countB != $cpf[10]) {
			return FALSE;
		}else{
			return TRUE;
		}
	}

// VALIDACAO DE EMAIL
	function mail_valid ($email) {
		if (preg_match('/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/',$email)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

// FUNCAO DE ENVIO DE EMAILS
	function sendMail($assunto,$mensagem,$remetente,$nomeRemetente,$destino,$nomeDestino,$reply = NULL,$replyNome = NULL){

			require_once('mail/class.phpmailer.php'); //Include pasta/classe do PHPMailer

			$mail = new PHPMailer(); //STARTS CLASSE
			$mail->IsSMTP(); //HABILITA ENVIO SMTP
			$mail->SMTPAuth = TRUE; //ATIVA EMAIL AUTENTICADO
			$mail->IsHTML(TRUE); //AQUI DETERMINAMOS QUE PODEMOS UTILIZAR HTML NO ENVIO DOS EMAILS

			$mail->Host = MAILHOST; //SERVIDOR DE ENVIO
			$mail->Port = MAILPORT; //PORTA DE ENVIO
			$mail->Username = MAILUSER; //EMAIL PARA SMTP AUTENTICADO
			$mail->Password = MAILPASS; //PORTA DE ENVIO

			$mail->From = utf8_decode($remetente); //REMETENTE
			$mail->FromName = utf8_decode($nomeRemetente); //REMETENTE NOME

			// CONDICAO PARA CHAMAR EMAIL DE RESPOSTA
			if ($reply != NULL) {
				$mail->AddReplyTo(utf8_decode($reply),utf8_decode($replyNome));
			}
			
			$mail->Subject = utf8_decode($assunto); //ASSUNTO
			$mail->Body = utf8_decode($mensagem); //MENSAGEM echo '<span>Erro ao enviar email. Por favor entre em contato pelo e-mail contato@raloliver.com!</span>';
			$mail->AddAddress(utf8_decode($destino),utf8_decode($nomeDestino)); //EMAIL E NOME DESTINO echo '<span>Mensagem enviada com sucesso! Obrigado.</span>';

			if($mail->Send()){
			 return TRUE;
			}else{
			 return FALSE;
			}
		}

// FUNCAO PARA FORMATAR DATA EM TIMESTAMP
		function formDate($data) {
			// AQUI RECEBER O PADRAO PARA ENTAO EFETUAR O TIMESTAMP
			$timestamp 	= explode(" ", $data);
			$getData	= $timestamp[0];
			$getTime	= $timestamp[1];

				$setData	= explode('/', $getData);
				$dia 		= $setData[0];
				$mes 		= $setData[1];
				$ano 		= $setData[2];
			// AQUI VAMOS DEFINIR AS HORAS, CASO SELECIONA OU NAO
				if (!$getTime):
					$getTime = date('H:i:s');
				endif;
			$result 	= $ano.'-'.$mes.'-'.$dia.' '.$getTime;

			return $result;
		}

// GERENCIAR ESTATISTICAS
		function viewManager($times = 900) {
			// VERIFICAR MES E ANO
			$secMonth = date ('m');
			$secYear  = date ('Y');

			// CASO NAO EXISTA UMA SESSAO, DEVEMOS INICIA-LA
			if (empty($_SESSION['startView']['session'])) {
				$_SESSION['startView']['session'] 	= session_id();
				$_SESSION['startView']['ip'] 	 	= $_SERVER['REMOTE_ADDR'];
				$_SESSION['startView']['url'] 	 	= $_SERVER['PHP_SELF'];
				$_SESSION['startView']['time_end']  = time() + $times;
				// APOS INICIAR A SESSAO, DEVEMOS PASSAR OS DADOS PARA A TABELA
				create('rows_views_online',$_SESSION['startView']);

				// CASO O MES/ANO NAO EXISTAM, AQUI DEVEMOS CRIA-LO
				$readViews = read('rows_views', "WHERE month = '$secMonth' AND year = '$secYear'");
				if (!$readViews) {
					$createViews = array ('month' => $secMonth, 'year' => $secYear);
					create('rows_views', $createViews);
				}else{
					foreach ($readViews as $views);
					// AQUI VERIFICAMOS O VISITANTES DO DIA
					if (empty($_COOKIE['startView'])) {
						$updateViews = array (
							'views'  	=> $views['views']+1,
							'visitors' 	=> $views['visitors']+1,
							);
						update('rows_views', $updateViews, "month = '$secMonth' AND year = '$secYear' ");
						// COMO JA HOUVE UMA VISITA DESSE USER NO DIA, DEVEMOS SETAR UM COOOKIE DE 24H
						setcookie('startView',time(),time()+60*60*24,'/');
						// CASO EXISTA, VAMOS ATUALIZAR AS VISITAS
					}else{
						$updateVisitas = array ('views' => $views['views']+1);
						update('rows_views', $updateVisitas, "month = '$secMonth' AND year = '$secYear' ");
					}
				}
			}else{
			// AQUI CONTAMOS OS PAGEVIEWS
				$readPageViews = read('rows_views',"WHERE month = '$secMonth' AND year = '$secYear'");
				// AQUI CONFERIMOS SE EXISTE 
				if ($readPageViews) {
					foreach ($readPageViews as $rpgv);
					$updatePageViews = array ('pageviews' => $rpgv['pageviews']+1);
					// AGORA SIM, EXECUTAMOS
					update('rows_views', $updatePageViews, "month = '$secMonth' AND year = '$secYear' ");
				}


			// SE EXISTIR A SESSAO E O TIME_END FOR MENOR QUE O TEMPO ATUAL, FINALIZAR A SESSAO
				$id_session = $_SESSION['startView']['session'];
				// SE O TEMPO FOR MENOR QUE TIMES, FINALIZAR A SESSAO
				if ($_SESSION['startView']['time_end'] <= time()) {
					// APOS FINALIZAR A SESSAO, E NECESSARIO APAGAR OS DADOS DO BD
					delete('rows_views_online',"session = '$id_session' OR time_end <= time(NOW()) ");
					unset($_SESSION['startView']);
				}else{
					// CASO O USER CONTINUE LOGADO, E NECESSARIO ATUALIZAR A SESSAO
					$_SESSION['startView']['time_end']  = time() + $times;
					// AGORA DEVEMOS ATUALIAR O TIME_END NA TABELA
					$timeEnd = array('time_end' => $_SESSION['startView']['time_end']);
					update('rows_views_online', $timeEnd, "session = '$id_session'");
				}
			}
		}
 ?>