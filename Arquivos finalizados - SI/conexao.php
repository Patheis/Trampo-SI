<?php
	$servidor = "localhost";
	$usuario = "root";
	$senha = "";
	$dbname = "DB";
	
	$mysqli = new mysqli($servidor, $usuario, $senha, $dbname);

	//Criar a conexao
	$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
