<?php
header("content-type: text/html;charset=utf-8");
$host = 'localhost';
$user = 'root';
$password = '';

// conectando ao banco de dados e verificando valores
$connect = mysqli_connect($host, $user, $password) or die("Não foi possível ligar ao servidor...");

// selecionando banco de dados
$db = mysqli_select_db($connect, 'yorah') or die("Impossível entrar no Banco de dados.");

// passando os comandos de acentuação
mysqli_query($connect,"SET NAMES 'utf8'");
mysqli_query($connect,"SET character_set_connection=utf8");
mysqli_query($connect,"SET character_set_client=utf8");
mysqli_query($connect,"SET character_set_results=utf8");