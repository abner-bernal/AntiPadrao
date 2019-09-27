<?php
include("../db.php");
$retornof = array();

$nome_form = trim(filter_input(INPUT_POST, 'nome_form_solucao'));
$alvo_form = filter_input(INPUT_POST, 'alvo_form_solucao');
$descricao_form = trim(filter_input(INPUT_POST, 'descricao_form_solucao'));
$id_form = trim(filter_input(INPUT_POST, 'id_form_solucao'));

if($nome_form != '' && $alvo_form!= '' && $descricao_form != ''){
    
    if(strlen($id_form) == 0){ //cadastrar solucao
        $insert_solucao = mysqli_query($connect, "INSERT INTO solucao (nome_solucao, descricao, alvo) VALUES ('$nome_form', '$descricao_form','$alvo_form')");

        if($insert_solucao){
            $select_solucao = mysqli_query($connect, "SELECT * FROM solucao WHERE nome_solucao = '$nome_form' AND alvo = '$alvo_form'");
            $solucao = mysqli_fetch_array($select_solucao);
            $id_solucao = $solucao['id_solucao'];

            $cont = 1;
            while ($cont<=20){
                $passo = filter_input(INPUT_POST, 'passo'.$cont.'_form_solucao');
                if($passo != '' && $passo != NULL){
                    $insert_passo = mysqli_query($connect, "INSERT INTO passos (id_solucao, passo, descricao) VALUES ('$id_solucao', $cont,'$passo')");
                }else {
                    $retornof = array('salvo'=>TRUE, 'mensag'=>'Cadastrado com Sucesso!');
                    break;
                }
                $cont++;
            }
            if(null !== (filter_input(INPUT_POST, 'conteudo_relacao'))){
                // Faz loop pelo array 
                foreach($_POST['conteudo_relacao'] as $id_conteudo){
                    $insert_relacao = mysqli_query($connect, "INSERT INTO relacao_conteudo_solucao (id_solucao, id_conteudo) VALUES ('$id_solucao','$id_conteudo')");
                }
            }
        }else{
            $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha no Cadastro!');
        }
    }else{ //salvar solucao ja cadastrada
        $verif = FALSE;
        
        //Banco de dados
        $select_solucao = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id_form'") or die(mysql_error());
        $results = mysqli_fetch_array($select_solucao);
        
        $nome = $results['nome_solucao'];
        $alvo = $results['alvo'];
        $descricao = $results['descricao'];
    
        if(strcasecmp($nome, $nome_form) != 0){
            $verif = TRUE;
            $update_nome = mysqli_query($connect, "UPDATE solucao SET nome_solucao = '$nome_form' WHERE id_solucao = '$id_form'") or die(mysql_error());
            if($update_nome){
                $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
            }
        }
        if(strcasecmp($descricao, $descricao_form) != 0){
            $verif = TRUE;
            $update_descricao = mysqli_query($connect, "UPDATE solucao SET descricao = '$descricao_form' WHERE id_solucao = '$id_form'") or die(mysql_error());
            if($update_descricao){
                $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
            }
        }
        if(strcasecmp($alvo, $alvo_form) != 0){
            $verif = TRUE;
            $select_alvo = mysqli_query($connect, "SELECT * FROM solucao WHERE nome_solucao = '$nome' AND alvo = '$alvo_form'") or die(mysql_error());
            $num_alvo = mysqli_num_rows($select_alvo);
            if($num_alvo == 0){
                $update_alvo = mysqli_query($connect, "UPDATE solucao SET alvo = '$alvo_form' WHERE id_solucao = '$id_form'") or die(mysql_error());
                if($update_alvo){
                    $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
                }
            }else{
                $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha: Solução para '.$alvo_form.' já cadastrada!');
            }
        }
        $cont = 1;
        while ($cont<=20){
            $descricao_passo_form = filter_input(INPUT_POST, 'passo'.$cont.'_form_solucao');
            
            if($descricao_passo_form != '' && $descricao_passo_form != NULL){ //se o usuario inseriu o passo
                $select_passos = mysqli_query($connect, "SELECT * FROM passos WHERE id_solucao = '$id_form' AND passo = '$cont'") or die(mysql_error());
                $passo_existe = mysqli_num_rows($select_passos);
                if($passo_existe == 0){ //verifica se já existe esse passo no banco de dados
                    $insert_passo = mysqli_query($connect, "INSERT INTO passos (id_solucao, passo, descricao) VALUES ('$id_form', $cont,'$descricao_passo_form')"); //caso não exista então insere
                }else{
                    $passos = mysqli_fetch_array($select_passos);
                    $descricao_passo = $passos['descricao'];
                    if(strcasecmp($descricao_passo, $descricao_passo_form) != 0){ //se já existe então verifica se foi editado
                        $update_passo = mysqli_query($connect, "UPDATE passos SET descricao = '$descricao_passo_form' WHERE id_solucao = '$id_form' AND passo = '$cont'") or die(mysql_error()); //caso sim então altere no banco
                        if($update_passo){
                            $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
                        }
                    }
                }   
            }else {
                $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
                break;
            }
            $cont++;
        }
        
        if(null !== (filter_input(INPUT_POST, 'conteudo_relacao'))){
            // Faz loop pelo array 
            $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo") or die(mysql_error());
            while ($resul_conteudo = mysqli_fetch_array($select_conteudo)){
                $id_conteudo = $resul_conteudo['id_conteudo'];
                $marcado = FALSE;
                
                foreach($_POST['conteudo_relacao'] as $id_conteudo_form){
                    if(strcasecmp($id_conteudo, $id_conteudo_form) == 0){ //esta marcado
                        $marcado = TRUE;
                        $select_relacao = mysqli_query($connect, "SELECT * FROM relacao_conteudo_solucao WHERE id_solucao = '$id_form' AND id_conteudo = '$id_conteudo_form'");
                        $relacao_existe = mysqli_num_rows($select_relacao);
                        if($relacao_existe == 0){ //verifica se já existe no banco de dados
                            $insert_relacao = mysqli_query($connect, "INSERT INTO relacao_conteudo_solucao (id_solucao, id_conteudo) VALUES ('$id_form','$id_conteudo')"); //caso não exista então insere
                        }
                    }  
                }
                if($marcado == FALSE){//nao está marcado
                    $deleta_relacao = mysqli_query($connect, "DELETE FROM relacao_conteudo_solucao WHERE id_solucao = '$id_form' AND id_conteudo = '$id_conteudo'");
                }
            }
        }else{
            $deleta_relacao = mysqli_query($connect, "DELETE FROM relacao_conteudo_solucao WHERE id_solucao = '$id_form'");
        }
        
        
        if($verif == FALSE){
            $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
        }
        
    }
}else{
    $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha: Campo Vazio!');
}

$json_str = json_encode($retornof);
echo "$json_str";