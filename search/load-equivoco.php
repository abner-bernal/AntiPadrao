<?php
include("../db.php");
$id = filter_input(INPUT_POST, 'id');
$solucao_prof = array();
$solucao_aluno = array();

$select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_equivoco = '$id'") or die(mysql_error());
$results = mysqli_fetch_array($select_equivoco);

$titulo = $results['titulo'];

$id_tipo = $results['id_tipo'];
$id_linguagem = $results['id_linguagem'];
$id_conteudo = $results['id_conteudo'];
$id_solucao_professor = $results['id_solucao_professor'];
$id_solucao_aluno = $results['id_solucao_aluno'];

$corpo = $results['corpo'];
$imagem = $results['imagem'];

$select_tipo = mysqli_query($connect, "SELECT * FROM tipo WHERE id_tipo = '$id_tipo'") or die(mysql_error());
$resul_tipo = mysqli_fetch_array($select_tipo);
$tipo = $resul_tipo['nome_tipo'];

$select_lang = mysqli_query($connect, "SELECT * FROM linguagem WHERE id_linguagem = '$id_linguagem'") or die(mysql_error());
$resul_lang = mysqli_fetch_array($select_lang);
$lang = $resul_lang['nome_linguagem'];

$select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo WHERE id_conteudo = '$id_conteudo'") or die(mysql_error());
$resul_conteudo = mysqli_fetch_array($select_conteudo);
$conteudo = $resul_conteudo['nome_conteudo'];

$list_ocorre = array();
$select_ocorrencia = mysqli_query($connect, "SELECT * FROM ocorrencia WHERE id_equivoco = '$id'") or die(mysql_error());

while ($resul_ocorrencia = mysqli_fetch_array($select_ocorrencia)){
    $id_aluno = $resul_ocorrencia['id_aluno'];
    $id_lang = $resul_ocorrencia['id_linguagem'];
    $id_ocorrencia = $resul_ocorrencia['id_ocorrencia'];
    $sub_total = $resul_ocorrencia['sub_total'];

    $select_lang_ocorre = mysqli_query($connect, "SELECT * FROM linguagem WHERE id_linguagem = '$id_lang'") or die(mysql_error());
    $resul_lang_ocorre = mysqli_fetch_array($select_lang_ocorre);
    $lang_ocorre = $resul_lang_ocorre['nome_linguagem'];
    
    
    $select_erro = mysqli_query($connect, "SELECT * FROM tratamento WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 'e'") or die(mysql_error());
    $resul_erro = mysqli_fetch_array($select_erro);
    $contexto = $resul_erro['tentativa'];
    $imagem_erro = $resul_erro['imagem'];
    $observacao_erro = $resul_erro['observacao'];
    $submissao_erro = $resul_erro['submissao'];
    
    $list_erro = array("contexto_erro" => $contexto, "imagem_erro" => $imagem_erro, "observacao_erro" => $observacao_erro, "submissao_erro" => $submissao_erro);
    

    $list_trat = array();
    $select_tratamento = mysqli_query($connect, "SELECT * FROM tratamento WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 't'") or die(mysql_error());
    
    while ($resul_tratamento = mysqli_fetch_array($select_tratamento)){
        $imagem_trat = $resul_tratamento['imagem'];
        $observacao_trat = $resul_tratamento['observacao'];
        $submissao_trat = $resul_tratamento['submissao'];
        
        $trat = array("imagem_trat" => $imagem_trat, "observacao_trat" => $observacao_trat, "submissao_trat" => $submissao_trat);
        array_push($list_trat, $trat);
    }
    
    $ocorre = array("id_aluno" => $id_aluno, "lang_ocorre" => $lang_ocorre, "sub_total" => $sub_total, "list_erro" => $list_erro, "list_trat" => $list_trat);

    array_push($list_ocorre, $ocorre);
}

if($id_solucao_professor !== null && $id_solucao_professor !== 0){
    $select_solucao_prof = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id_solucao_professor'") or die(mysql_error());
    $resul_prof = mysqli_fetch_array($select_solucao_prof);

    $descricao_prof = $resul_prof['descricao'];
    
    $list_passos_prof = array();
    $select_passos_prof = mysqli_query($connect, "SELECT * FROM passos WHERE id_solucao = '$id_solucao_professor'") or die(mysql_error());

    while ($resul_passos = mysqli_fetch_array($select_passos_prof)){
        $passo = $resul_passos['passo'];
        $descricao_passo = $resul_passos['descricao'];

        $passos_prof = array("passo" => $passo, "descricao_passo" => $descricao_passo);
        array_push($list_passos_prof, $passos_prof);

    }
    $solucao_prof = array("id_solucao_prof" => $id_solucao_professor, "descricao_solucao_prof" => $descricao_prof, "list_passos_prof" => $list_passos_prof);
}

if($id_solucao_aluno !== null && $id_solucao_aluno !== 0){
    $select_solucao_aluno = mysqli_query($connect, "SELECT * FROM solucao WHERE id_solucao = '$id_solucao_aluno'") or die(mysql_error());
    $resul_aluno = mysqli_fetch_array($select_solucao_aluno);
    
    $descricao_aluno = $resul_aluno['descricao'];
    
    $list_passos_aluno = array();
    $select_passos_aluno = mysqli_query($connect, "SELECT * FROM passos WHERE id_solucao = '$id_solucao_aluno'") or die(mysql_error());

    while ($resul_passos = mysqli_fetch_array($select_passos_aluno)){
        $passo = $resul_passos['passo'];
        $descricao_passo = $resul_passos['descricao'];

        $passos_aluno = array("passo" => $passo, "descricao_passo" => $descricao_passo);
        array_push($list_passos_aluno, $passos_aluno);

    }
    $solucao_aluno = array("id_solucao_aluno" => $id_solucao_aluno, "descricao_solucao_aluno" => $descricao_aluno, "list_passos_aluno" => $list_passos_aluno);
}

$result_solucao = array_merge($solucao_prof, $solucao_aluno);

$equivoco = array("titulo" => $titulo, "corpo" => $corpo, "imagem" => $imagem, "tipo" => $tipo, "lang" => $lang, "conteudo" => $conteudo, "list_ocorre" => $list_ocorre);
$retornof = array_merge($equivoco, $result_solucao);

$json_str = json_encode($retornof);
echo "$json_str";