<?php
include("../db.php");
$string = filter_input(INPUT_POST, 'string');
$retornof = array();

$raw_results = mysqli_query($connect, "SELECT * FROM tipo WHERE (nome_tipo like '".$string."%')") or die(mysql_error());

if (mysqli_num_rows($raw_results) > 0) {
    array_push($retornof, FALSE);
    
    while ($results = mysqli_fetch_array($raw_results)) {
        $tipo = $results['nome_tipo'];
        array_push($retornof, $tipo);
    }
    
}else{
    array_push($retornof, TRUE);
}

$json_str = json_encode($retornof);
echo "$json_str";