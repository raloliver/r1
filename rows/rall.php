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
 ?>