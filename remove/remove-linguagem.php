<?php
include("../db.php");
$linguagem = filter_input(INPUT_POST, 'linguagem_rem');

$raw_results = mysqli_query($connect, "SELECT * FROM linguagem WHERE (nome_linguagem like '%".$linguagem."%')") or die(mysqli_error());

if (mysqli_num_rows($raw_results) != 0) {
    $deleta_lang = mysqli_query($connect, "DELETE FROM linguagem WHERE nome_linguagem = '$linguagem'");
    
    if($deleta_lang){
        $retornof = array('removeu'=>TRUE);
    }
}else{
    $retornof = array('removeu'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";