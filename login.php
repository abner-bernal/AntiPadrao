<?php 
include("db.php");
session_start();
    
$email = filter_input(INPUT_POST, 'email');
$senha = md5(filter_input(INPUT_POST, 'senha'));

$verifica = mysqli_query($connect, "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'") or die("erro ao selecionar");

  if(mysqli_num_rows ($verifica) > 0 ){
    $_SESSION['email'] = $login;
    $_SESSION['senha'] = $senha;
    
    $array = mysqli_fetch_array($verifica);
    $_SESSION['nome'] = $array['nome'];
    
    header('location:index.php');
  }else{
    unset ($_SESSION['email']);
    unset ($_SESSION['senha']);
    echo"<script language='javascript' type='text/javascript'>alert('Não foi possível Efetuar o Login');window.location.href='index.php'</script>";
  }