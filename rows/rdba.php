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

// FUNCAO DE LEITURA
	function read($tabela, $condicao = NULL){		
			$query_read = "SELECT * FROM {$tabela} {$condicao}";
			// AQUI PODERIAMOS CRIAR UMA VARIAVEL PARA CADA FILTRO, POREM COMO TEMOS UMA FUNCAO GENERICA, O IDEAL E QUE SEJA GERAL
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

// FUNCAO DE EDICAO
	function update($tabela, array $datas, $where){
		// AQUI ARMAZENAMOS OS DADOS DENTRO DE ARRAY PESSOAL
			foreach ($datas as $fields => $values) {
				// ESSA CONDICAO SE REFERENCIA A FORMA COMO MONTAMOS O CRUD
				$fields_up[] = "$fields = '$values'";
			}
				$fields_up		= implode(", ", $fields_up);
				$query_update	= "UPDATE {$tabela} SET $fields_up WHERE {$where}";
				$string_update	= mysql_query($query_update) or die ('Erro ao atualizar dados! '.$tabela.' '.mysql_error());

				if ($string_update) {
					return TRUE;
				}
	}

// FUNCAO DE DELETAR
	function delete ($tabela, $where){
		$query_delete 	= "DELETE FROM {$tabela} WHERE {$where}";
		$string_delete	= mysql_query($query_delete) or die ('Erro ao deletar dados! '.$tabela.' '.mysql_error());
	}
 ?>