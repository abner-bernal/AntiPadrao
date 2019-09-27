<?php
include("../db.php");
$titulo = filter_input(INPUT_POST, 'titulo');
$id = filter_input(INPUT_POST, 'id');
$retornof = array();

if($id != NULL && $titulo != NULL){
    $raw_results = mysqli_query($connect, "SELECT * FROM equivoco WHERE (titulo like '%".$titulo."%') AND (id_equivoco like '%".$id."%')") or die(mysql_error());
}else if($id != NULL){
    $raw_results = mysqli_query($connect, "SELECT * FROM equivoco WHERE (id_equivoco like '%".$id."%')") or die(mysql_error());
}else{
    $raw_results = mysqli_query($connect, "SELECT * FROM equivoco WHERE (titulo like '%".$titulo."%')") or die(mysql_error());
}


if (mysqli_num_rows($raw_results) > 0) {
    array_push($retornof, FALSE);
    
    while ($results = mysqli_fetch_array($raw_results)) {
        $titulo_res = $results['titulo'];
        $id_res = $results['id_equivoco'];
        $linha = array("titulo" => $titulo_res, "id" => $id_res);
        array_push($retornof, $linha);
    }
    
}else{
    array_push($retornof, TRUE);
}

$json_str = json_encode($retornof);
echo "$json_str";
