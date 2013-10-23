<?php 
// ACESSO SO ARQUIVO DE CONFIGURACAO
require('rsys.php');

// CONECTAR BD
$conect = mysql_connect(HOST, USER, PASS) or die ('Erro na conexão com o Banco de Dados! '.mysql_error());
$dbsa	= mysql_select_db(DBSA) or die ('Erro na seleção do Banco de Dados! '.mysql_error());

// FUNCOES GENERICAS

// FUNCAO DE CADASTRO
	function create($tabela, array $datas) {
			$fields = implode(", ", array_keys($datas));
			$values = "'".implode("', '", array_values($datas))."'";
			// DENTRO DE UM INSERT DEVEMOS UTILIZAR AS {} PARA SE REVERENCIAR A UMA VARIAVEL
			$query_create 	= "INSERT INTO {$tabela} ($fields) VALUES ($values) ";
			$string_create	= mysql_query($query_create) or die ('Erro ao inserir dados! '.$tabela.' '.mysql_error());

			if ($string_create) {
				return TRUE;
			}
	}

// FUNCAO DE CADASTRO LEITURA
	function read($tabela, $condicao = NULL){		
			$query_read = "SELECT * FROM {$tabela} {$condicao}";
			$string_read = mysql_query($query_read) or die ('Erro ao ler dados! '.$tabela.' '.mysql_error());
			$fields_count = mysql_num_fields($string_read);
			for($y = 0; $y < $fields_count; $y++){
				$names[$y] = mysql_field_name($string_read,$y);
			}
			for($x = 0; $result = mysql_fetch_assoc($string_read); $x++){
				for($i = 0; $i < $fields_count; $i++){
					$results[$x][$names[$i]] = $result[$names[$i]];
				}
			}
			return $results;
		}

 ?>