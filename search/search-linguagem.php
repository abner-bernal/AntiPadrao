<?php
include("../db.php");
$string = filter_input(INPUT_POST, 'string');
$retornof = array();

$raw_results = mysqli_query($connect, "SELECT * FROM linguagem WHERE (nome_linguagem like '".$string."%')") or die(mysql_error());

if (mysqli_num_rows($raw_results) > 0) {
    array_push($retornof, FALSE);
    
    while ($results = mysqli_fetch_array($raw_results)) {
        $lang = $results['nome_linguagem'];
        array_push($retornof, $lang);
    }
    
}else{
    array_push($retornof, TRUE);
}

$json_str = json_encode($retornof);
echo "$json_str";