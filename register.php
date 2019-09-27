<?php
session_start();
include("db.php");

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email');
$senha = MD5(filter_input(INPUT_POST, 'senha'));
$cargo = filter_input(INPUT_POST, 'cargo');
$codigo = filter_input(INPUT_POST, 'cod');

$select = mysqli_query($connect, "SELECT email FROM usuario WHERE email = '$email'");
$array = mysqli_fetch_array($select);
$logarray = $array['email'];

if($email == "" || $email == null){
    echo"<script language='javascript' type='text/javascript'>document.getElementById('erro-input2').innerHTML = 'Digite seu endereço de e-mail';</script>";
}else{
    if($logarray == $email){
        echo"<script language='javascript' type='text/javascript'>alert('Esse e-mail já está cadastrado');</script>";
        die();
    }else{
        $insert = mysqli_query($connect, "INSERT INTO usuario (nome, email, senha, funcao) VALUES ('$nome', '$email','$senha','$cargo')");
        
        if($insert){
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha; 
            $_SESSION['nome'] = $nome;

            header('location:index.php');
        }else{
            echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='login.php'</script>";
        }
    }
}