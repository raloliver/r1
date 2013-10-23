<?php 
	// CONSTANTES
	define('HOST', 'localhost');
	define('USER', 'root');
	define('PASS', '');
	define('DBASE', 'php');

	// CONEXAO COM O MYSQL
	$conect = mysql_connect(HOST,USER,PASS) or die ('Falha ao conectar: <strong>'.mysql_error().'</strong>'); //IP Address, User, Pass
	// CONEXAO COM O BANCO DE DADOS
	$dbase = mysql_select_db(DBASE) or die ('Erro na conxeção com o banco de dados: <strong>'.mysql_error().'</strong>');
 ?>