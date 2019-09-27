<?php
include("../db.php");
$retornof = array();

$nome = trim(filter_input(INPUT_POST, 'nome'));
$alvo = filter_input(INPUT_POST, 'alvo');
$descricao = trim(filter_input(INPUT_POST, 'descricao'));

$list_passos = json_decode(filter_input(INPUT_POST, 'list_passos'));


if($nome != '' && $alvo!= '' && $descricao != ''){
    $insert_solucao = mysqli_query($connect, "INSERT INTO solucao (nome_solucao, descricao, alvo) VALUES ('$nome', '$descricao','$alvo')");

    if($insert_solucao){
        $select_solucao = mysqli_query($connect, "SELECT * FROM solucao WHERE nome_solucao = '$nome' AND alvo = '$alvo'");
        $solucao = mysqli_fetch_array($select_solucao);
        $id_solucao = $solucao['id_solucao'];
        
        $cont = 1;
        foreach($list_passos as $descricao_passo){            
            $insert_passo = mysqli_query($connect, "INSERT INTO passos (id_solucao, passo, descricao) VALUES ('$id_solucao', $cont,'$descricao_passo')");
            if($insert_passo){
                $cont++;
            }else{
                //apaga passos inseridos e solucao inserida
                $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha no Cadastro: Passos!');
                break;
            }
        }
        $retornof = array('salvo'=>TRUE, 'mensag'=>'Cadastrado com Sucesso!', 'id_solucao'=>$id_solucao);
        /*
        if(null !== (filter_input(INPUT_POST, 'conteudo_relacao'))){
            // Faz loop pelo array 
            foreach($_POST['conteudo_relacao'] as $id_conteudo){
                $insert_relacao = mysqli_query($connect, "INSERT INTO relacao_conteudo_solucao (id_solucao, id_conteudo) VALUES ('$id_solucao','$id_conteudo')");
            }
        }*/
    }else{
        $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha no Cadastro!');
    }
}else{
    $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha: Campo Vazio!');
}

$json_str = json_encode($retornof);
echo "$json_str";