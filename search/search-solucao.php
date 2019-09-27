<?php
include("../db.php");
$nome = filter_input(INPUT_POST, 'nome');
$id = filter_input(INPUT_POST, 'id');
$id_conteudo = filter_input(INPUT_POST, 'id_conteudo');
$retornof = array();

if(($id != NULL || $nome != NULL) && (strlen($id_conteudo) != 0)){
    
    $select_relacao = mysqli_query($connect, "SELECT * FROM relacao_conteudo_solucao WHERE id_conteudo = '$id_conteudo'");
    
    if (mysqli_num_rows($select_relacao) > 0) {
        array_push($retornof, FALSE); //vazio false
    
        while($relacao = mysqli_fetch_array($select_relacao)) {
            $id_solucao = $relacao['id_solucao'];

            if($id != NULL && $nome != NULL){
                $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (nome_solucao like '%".$nome."%') AND (id_solucao like '%".$id."%') AND id_solucao = '$id_solucao'") or die(mysql_error());
            }else if($id != NULL){
                $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (id_solucao like '%".$id."%') AND id_solucao = '$id_solucao'") or die(mysql_error());
            }else if($nome != NULL){
                $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (nome_solucao like '%".$nome."%') AND id_solucao = '$id_solucao'") or die(mysql_error());
            }
            
            if (mysqli_num_rows($raw_results) > 0) {
                $solucao = mysqli_fetch_array($raw_results);
                $nome_solucao = $solucao['nome_solucao'];

                $linha = array("nome" => $nome_solucao, "id" => $id_solucao);
                array_push($retornof, $linha);
            }
        }
    }
    
}else if($id != NULL || $nome != NULL){ //pesquisa só com nome ou id ou os dois
    if($id != NULL && $nome != NULL){
        $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (nome_solucao like '%".$nome."%') AND (id_solucao like '%".$id."%')") or die(mysql_error());
    }else if($id != NULL){
        $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (id_solucao like '%".$id."%')") or die(mysql_error());
    }else if($nome != NULL){
        $raw_results = mysqli_query($connect, "SELECT * FROM solucao WHERE (nome_solucao like '%".$nome."%')") or die(mysql_error());
    }

    if (mysqli_num_rows($raw_results) > 0) {
        array_push($retornof, FALSE);

        while ($results = mysqli_fetch_array($raw_results)) {
            $nome_res = $results['nome_solucao'];
            $id_res = $results['id_solucao'];
            $linha = array("nome" => $nome_res, "id" => $id_res);
            array_push($retornof, $linha);
        }
    }else{
        array_push($retornof, TRUE);
    }
}else if(strlen($id_conteudo) != 0){ //pesquisa só com conteudo
    $select_relacao = mysqli_query($connect, "SELECT * FROM relacao_conteudo_solucao WHERE id_conteudo = '$id_conteudo'");
    
    if (mysqli_num_rows($select_relacao) > 0) {
        array_push($retornof, FALSE); //vazio false
    
        while($relacao = mysqli_fetch_array($select_relacao)) {
            $id_solucao = $relacao['id_solucao'];

            $select_solucao = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id_solucao'");
            $solucao = mysqli_fetch_array($select_solucao);
            
            $nome_solucao = $solucao['nome_solucao'];

            $linha = array("nome" => $nome_solucao, "id" => $id_solucao);
            array_push($retornof, $linha);
        }
    }
}



$json_str = json_encode($retornof);
echo "$json_str";
