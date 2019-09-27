<?php
include("../db.php");
$tipo = filter_input(INPUT_POST, 'tipo_rem');
$retornof = array();
$raw_results = mysqli_query($connect, "SELECT * FROM tipo WHERE (nome_tipo like '%".$tipo."%')") or die(mysqli_error());

if (mysqli_num_rows($raw_results) != 0) {
    $deleta_tipo = mysqli_query($connect, "DELETE FROM tipo WHERE nome_tipo = '$tipo'");
    
    if($deleta_tipo){
        $retornof = array('removeu'=>TRUE);
    }
}else{
    $retornof = array('removeu'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";