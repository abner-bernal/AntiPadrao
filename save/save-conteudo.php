<?php
include("../db.php");
$conteudo = trim(filter_input(INPUT_POST, 'conteudo_cad'));

$raw_results = mysqli_query($connect, "SELECT * FROM conteudo WHERE nome_conteudo = '$conteudo'") or die(mysqli_error());

if (mysqli_num_rows($raw_results) == 0) {
    $insert_conteudo = mysqli_query($connect, "INSERT INTO conteudo (nome_conteudo) VALUES ('$conteudo')");
    
    if($insert_conteudo){
        $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo WHERE nome_conteudo = '$conteudo'");
        $cont = mysqli_fetch_array($select_conteudo);
        $id_conteudo = $cont['id_conteudo'];
                
        $retornof = array('salvo'=>TRUE, 'id_conteudo'=>$id_conteudo);
    }
}else{
    $retornof = array('salvo'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";