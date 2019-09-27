<?php
session_start();
include("db.php");

$titulo = filter_input(INPUT_POST, 'titulo');
$tipo = filter_input(INPUT_POST, 'erro');
$linguagem = filter_input(INPUT_POST, 'linguagem');
$conteudo = filter_input(INPUT_POST, 'conteudo');
$corpo = filter_input(INPUT_POST, 'corpo');
$aluno = filter_input(INPUT_POST, 'aluno');
$ling_exp = filter_input(INPUT_POST, 'ling_exp');
$contexto = filter_input(INPUT_POST, 'contexto');
$solucao = filter_input(INPUT_POST, 'solucao');
$ligacao = filter_input(INPUT_POST, 'ligacao');

$pasta = "images/";

/* formatos de imagem permitidos */
$permitidos = array(".jpg",".jpeg",".png", ".bmp");

$nome_imagem    = $_FILES['exemplo_img']['name'];
$tamanho_imagem = $_FILES['exemplo_img']['size'];


/* pega a extensão do arquivo */
$ext = strtolower(strrchr($nome_imagem,"."));

/*  verifica se a extensão está entre as extensões permitidas */
if(in_array($ext,$permitidos)){

    /* converte o tamanho para KB */
    $tamanho = round($tamanho_imagem / 1024);

    if($tamanho < 1024){ //se imagem for até 1MB envia
        $nome_atual = md5(uniqid(time())).$ext; 
        //nome que dará a imagem
        $tmp = $_FILES['exemplo_img']['tmp_name']; 
        //caminho temporário da imagem
        $caminho = $pasta.$nome_atual;
        /* se enviar a foto, insere o nome da foto no banco de dados */
        if(move_uploaded_file($tmp,$caminho)){
            $insert_exemp = mysqli_query($connect, "INSERT INTO exemplo (imagem, linguagem, contexto, id_aluno) VALUES ('$caminho', '$ling_exp','$contexto','$aluno')");
        }else{
            echo"<script language='javascript' type='text/javascript'>alert('Falha ao enviar');</script>";
        }
    }else{
        echo"<script language='javascript' type='text/javascript'>alert('A imagem deve ser de no máximo 1MB');</script>";
    }
}else{
    echo"<script language='javascript' type='text/javascript'>alert('Somente são aceitos arquivos do tipo Imagem');</script>";
}

if($insert_exemp){

    $select_exemp = mysqli_query($connect, "SELECT * FROM exemplo WHERE imagem = '$caminho'");
    $exemplos = mysqli_fetch_array($select_exemp);
    $id_exemplo = $exemplos['id_exemplo'];
    $insert_anti = mysqli_query($connect, "INSERT INTO anti_padrao (titulo, tipo, linguagem, conteudo, corpo, id_exemplo, solucao, ligacao) VALUES ('$titulo', '$tipo','$linguagem','$conteudo','$corpo','$id_exemplo','$solucao','$ligacao')");
    
    if($insert_anti){
        $select_anti = mysqli_query($connect, "SELECT * FROM anti_padrao WHERE id_exemplo = '$id_exemplo'");
        $anti = mysqli_fetch_array($select_anti);
        $id_anti_padrao = $anti['id_anti_padrao'];
        $cont = 1;
        while ($cont<=10){
            $passo = filter_input(INPUT_POST, 'passo'.$cont.'');
            if($passo != '' || $passo != NULL){
                $insert_passo = mysqli_query($connect, "INSERT INTO passos (id_anti_padrao, passo, descricao) VALUES ('$id_anti_padrao', $cont,'$passo')");
            }else {
                break;
            }
            $cont++;
        }
        $cont2 = 1;
        while ($cont2<=10){
            $nome_imagem = $_FILES['tentativa_img'.$cont2]['name'];
            
            if($nome_imagem != '' || $nome_imagem != NULL){
                $tamanho_imagem = $_FILES['tentativa_img'.$cont2]['size'];
                $observacao = filter_input(INPUT_POST, 'tentativa'.$cont2);

                /* pega a extensão do arquivo */
                $ext = strtolower(strrchr($nome_imagem,"."));

                /*  verifica se a extensão está entre as extensões permitidas */
                if(in_array($ext,$permitidos)){

                    /* converte o tamanho para KB */
                    $tamanho = round($tamanho_imagem / 1024);

                    if($tamanho < 1024){ //se imagem for até 1MB envia
                        $nome_atual = md5(uniqid(time())).$ext; 
                        //nome que dará a imagem
                        $tmp = $_FILES['tentativa_img'.$cont2]['tmp_name']; 
                        //caminho temporário da imagem
                        $caminho = $pasta.$nome_atual;
                        /* se enviar a foto, insere o nome da foto no banco de dados */
                        if(move_uploaded_file($tmp,$caminho)){
                            $insert_tentativa = mysqli_query($connect, "INSERT INTO tratamento (id_exemplo, tentativa, imagem, observacao) VALUES ('$id_exemplo', '$cont2','$caminho','$observacao')");
                        }else{
                            echo"<script language='javascript' type='text/javascript'>alert('Falha ao enviar tentativa ".$cont2."');</script>";
                        }
                    }else{
                        echo"<script language='javascript' type='text/javascript'>alert('A imagem da tentativa ".$cont2." deve ser de no máximo 1MB');</script>";
                    }
                }else{
                    echo"<script language='javascript' type='text/javascript'>alert('Somente são aceitos arquivos do tipo Imagem: tentativa ".$cont2."');</script>";
                }
            }else {
                break;
            }
            $cont2++;
        }
        
        
    }
}
header('location:index.php');