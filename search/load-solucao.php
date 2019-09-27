<?php
include("../db.php");
$id = filter_input(INPUT_POST, 'id');

$select_solucao = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id'") or die(mysql_error());
$results = mysqli_fetch_array($select_solucao);

$nome = $results['nome_solucao'];
$descricao = $results['descricao'];
$alvo = $results['alvo'];

$list_passos = array();
$select_passos = mysqli_query($connect, "SELECT * FROM passos WHERE id_solucao = '$id'") or die(mysql_error());

while ($resul_passos = mysqli_fetch_array($select_passos)){
    $passo = $resul_passos['passo'];
    $descricao_passo = $resul_passos['descricao'];
    
    $passos = array("passo" => $passo, "descricao_passo" => $descricao_passo);
    array_push($list_passos, $passos);
    
}

$list_relacao = array();
$select_relacao = mysqli_query($connect, "SELECT * FROM relacao_conteudo_solucao WHERE id_solucao = '$id'");

while ($resul_relacao = mysqli_fetch_array($select_relacao)){
    $id_conteudo = $resul_relacao['id_conteudo'];
    array_push($list_relacao, $id_conteudo);
    
}

$retornof = array("nome" => $nome, "descricao" => $descricao, "alvo" => $alvo, "list_passos" => $list_passos, "list_relacao" => $list_relacao);
$json_str = json_encode($retornof);
echo "$json_str";