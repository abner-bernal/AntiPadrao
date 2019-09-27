<?php
include("../db.php");
$id_solucao = filter_input(INPUT_POST, 'id');
$retornof = array();

$raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id_solucao'") or die(mysqli_error());

if (mysqli_num_rows($raw_results) != 0) {
    
    $deleta_passos = mysqli_query($connect, "DELETE FROM passos WHERE id_solucao = '$id_solucao'");
    
    $deleta_solucao = mysqli_query($connect, "DELETE FROM solucao WHERE id_solucao = '$id_solucao'");
    
    if($deleta_solucao){
        $retornof = array('removeu'=>TRUE);
    }else{
        $retornof = array('removeu'=>FALSE);
    }
    
}else{
    $retornof = array('removeu'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";
