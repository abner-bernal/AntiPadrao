<?php
include("../db.php");
$tipo = trim(filter_input(INPUT_POST, 'tipo_cad'));

$raw_results = mysqli_query($connect, "SELECT * FROM tipo WHERE (nome_tipo like '%".$tipo."%')") or die(mysqli_error());

if (mysqli_num_rows($raw_results) == 0) {
    $insert_tipo = mysqli_query($connect, "INSERT INTO tipo (nome_tipo) VALUES ('$tipo')");
    
    if($insert_tipo){
        $retornof = array('salvo'=>TRUE);
    }
}else{
    $retornof = array('salvo'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";