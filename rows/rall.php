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
 ?>