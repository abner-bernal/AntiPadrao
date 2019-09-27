<?php
include("../db.php");
$id_equivoco = filter_input(INPUT_POST, 'id');
$retornof = array();

$raw_results = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_equivoco = '$id_equivoco'") or die(mysqli_error());

if (mysqli_num_rows($raw_results) != 0) {
    $select_ocorre = mysqli_query($connect, "SELECT * FROM ocorrencia WHERE id_equivoco = '$id_equivoco'") or die(mysqli_error());

    while ($ocorre = mysqli_fetch_array($select_ocorre)){
        $id_ocorre = $ocorre['id_ocorrencia'];
        
        $deleta_tratamento = mysqli_query($connect, "DELETE FROM tratamento WHERE id_ocorrencia = '$id_ocorre'");
        /*
        $select_tratamento = mysqli_query($connect, "SELECT * FROM tratamento WHERE id_ocorrencia = '$id_ocorre'") or die(mysqli_error());
        while ($trat = mysqli_fetch_array($select_tratamento)){
            
        }*/
        $deleta_ocorrencia = mysqli_query($connect, "DELETE FROM ocorrencia WHERE id_ocorrencia = '$id_ocorre'");
        
    }
    
    $deleta_equivoco = mysqli_query($connect, "DELETE FROM equivoco WHERE id_equivoco = '$id_equivoco'");
    
    if($deleta_equivoco){
        $retornof = array('removeu'=>TRUE);
    }
}else{
    $retornof = array('removeu'=>FALSE);
}

$json_str = json_encode($retornof);
echo "$json_str";