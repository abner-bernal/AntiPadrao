<?php
include("../db.php");
$lang = trim(filter_input(INPUT_POST, 'linguagem_cad'));

$raw_results = mysqli_query($connect, "SELECT * FROM linguagem WHERE (nome_linguagem like '%".$lang."%')") or die(mysqli_error());

if (mysqli_num_rows($raw_results) == 0) {
    $insert_lang = mysqli_query($connect, "INSERT INTO linguagem (nome_linguagem) VALUES ('$lang')");
    
    if($insert_lang){
        $retornof = array('salvo'=>TRUE);
    }
}else{
    $retornof = array('salvo'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";