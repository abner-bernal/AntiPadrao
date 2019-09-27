<?php
include("../db.php");
$conteudo = filter_input(INPUT_POST, 'conteudo_rem');

$raw_results = mysqli_query($connect, "SELECT * FROM conteudo WHERE (nome_conteudo like '%".$conteudo."%')") or die(mysqli_error());

if (mysqli_num_rows($raw_results) != 0) {
    $deleta_conteudo = mysqli_query($connect, "DELETE FROM conteudo WHERE nome_conteudo = '$conteudo'");
    
    if($deleta_conteudo){
        $retornof = array('removeu'=>TRUE);
    }else{
        $retornof = array('removeu'=>FALSE);
    }
}else{
    $retornof = array('removeu'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";