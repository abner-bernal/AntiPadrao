<?php
include("db.php");

$retornof = array();
$pasta = "images/";
$permitidos = array(".jpg",".jpeg",".png", ".bmp"); //formatos de imagem permitidos
$id_form = trim(filter_input(INPUT_POST, 'id_form'));

if(strlen($id_form) == 0){
    $titulo = trim(filter_input(INPUT_POST, 'titulo_form'));
    $tipo = filter_input(INPUT_POST, 'tipo_form');
    $linguagem = filter_input(INPUT_POST, 'linguagem_form');
    $conteudo = filter_input(INPUT_POST, 'conteudo_form');
    $corpo = filter_input(INPUT_POST, 'corpo_form');
    $id_solucao_prof = filter_input(INPUT_POST, 'nome_solucao_prof_form');   
    $id_solucao_aluno = filter_input(INPUT_POST, 'nome_solucao_aluno_form');
                               
    
    $select_tipo = mysqli_query($connect, "SELECT * FROM tipo WHERE nome_tipo = '$tipo'");
    $tipos = mysqli_fetch_array($select_tipo);
    $id_tipo = $tipos['id_tipo'];
    
    $select_linguagem = mysqli_query($connect, "SELECT * FROM linguagem WHERE nome_linguagem = '$linguagem'");
    $langs = mysqli_fetch_array($select_linguagem);
    $id_linguagem = $langs['id_linguagem'];
    
    $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo WHERE nome_conteudo = '$conteudo'");
    $conteudos = mysqli_fetch_array($select_conteudo);
    $id_conteudo = $conteudos['id_conteudo'];
    
    if (isset($_FILES['img_exemplo_form'])) {
        $nome_imagem_exe   = $_FILES['img_exemplo_form']['name'];
        $tamanho_imagem_exe = $_FILES['img_exemplo_form']['size'];

        $error = $_FILES['img_exemplo_form']['error'];
        if ($error !== UPLOAD_ERR_OK) {
            $retornof = array('salvo'=>FALSE, 'mensag'=>'Erro ao fazer o upload: '.$error);
            
        }else{
            $ext = strtolower(strrchr($nome_imagem_exe,".")); //pega a extensão do arquivo

            if(in_array($ext,$permitidos)){ //verifica se a extensão está entre as extensões permitidas

                $tamanho = round($tamanho_imagem_exe / 1024); //converte o tamanho para KB

                if($tamanho < 1024){ //se imagem for até 1MB envia
                    $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem

                    $tmp = $_FILES['img_exemplo_form']['tmp_name']; //caminho temporário da imagem
                    $caminho = $pasta.$nome_atual;

                    if(move_uploaded_file($tmp,$caminho)){ //se enviar a foto, insere o nome da foto no banco de dados
                        if($id_solucao_prof != '' && $id_solucao_aluno != ''){
                            $insert_equivoco = mysqli_query($connect, "INSERT INTO equivoco (titulo, id_tipo, id_linguagem, id_conteudo, id_solucao_professor, id_solucao_aluno, corpo, imagem) VALUES ('$titulo', '$id_tipo','$id_linguagem','$id_conteudo', '$id_solucao_prof', '$id_solucao_aluno', '$corpo','$caminho')");
                        }else if($id_solucao_prof != ''){
                            $insert_equivoco = mysqli_query($connect, "INSERT INTO equivoco (titulo, id_tipo, id_linguagem, id_conteudo, id_solucao_professor, corpo, imagem) VALUES ('$titulo', '$id_tipo','$id_linguagem','$id_conteudo', '$id_solucao_prof', '$corpo','$caminho')");
                        }else if ($id_solucao_aluno != ''){
                            $insert_equivoco = mysqli_query($connect, "INSERT INTO equivoco (titulo, id_tipo, id_linguagem, id_conteudo, id_solucao_aluno, corpo, imagem) VALUES ('$titulo', '$id_tipo','$id_linguagem','$id_conteudo', '$id_solucao_aluno', '$corpo','$caminho')");
                        }else{
                            $insert_equivoco = mysqli_query($connect, "INSERT INTO equivoco (titulo, id_tipo, id_linguagem, id_conteudo, corpo, imagem) VALUES ('$titulo', '$id_tipo','$id_linguagem','$id_conteudo','$corpo','$caminho')");
                        }
                        
                        if($insert_equivoco){ //se salvou equivoco
                            $select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE imagem = '$caminho' AND titulo = '$titulo'");
                            $equivoco = mysqli_fetch_array($select_equivoco);
                            $id_equivoco = $equivoco['id_equivoco'];

                            $cont1 = 1; //numero da ocorrencia
                            while ($cont1<=4){
                                $id_aluno = filter_input(INPUT_POST, 'aluno_ocorre'.$cont1.'_form');
                                $linguagem_ocorre = filter_input(INPUT_POST, 'lang_ocorre'.$cont1.'_form');
                                $sub_total = filter_input(INPUT_POST, 'sub_ocorre'.$cont1.'_form');

                                if(($id_aluno != ('' || NULL) ) && ($linguagem_ocorre != ('' || NULL))){
                                    
                                    $select_linguagem_ocorre = mysqli_query($connect, "SELECT * FROM linguagem WHERE nome_linguagem = '$linguagem_ocorre'");
                                    $lang_ocorre = mysqli_fetch_array($select_linguagem_ocorre);
                                    $id_linguagem_ocorre = $lang_ocorre['id_linguagem'];

                                    $insert_ocorrencia = mysqli_query($connect, "INSERT INTO ocorrencia (id_equivoco, ocorrencia, id_aluno, id_linguagem, sub_total) VALUES ('$id_equivoco', '$cont1','$id_aluno', '$id_linguagem_ocorre', '$sub_total')");

                                    if($insert_ocorrencia){ //se salvou a ocorrencia
                                        $select_ocorrencia = mysqli_query($connect, "SELECT * FROM ocorrencia WHERE id_equivoco = '$id_equivoco' AND ocorrencia = '$cont1'");
                                        $ocorrencia = mysqli_fetch_array($select_ocorrencia);
                                        $id_ocorrencia = $ocorrencia['id_ocorrencia'];
                                        
                                        if (isset($_FILES['erro_img_ocorre'.$cont1])) { //salvar erro da ocorrencia
                                                $nome_imagem_erro = $_FILES['erro_img_ocorre'.$cont1]['name'];
                                                $tamanho_imagem_erro = $_FILES['erro_img_ocorre'.$cont1]['size'];
                                                $observacao_erro = filter_input(INPUT_POST, 'erro_ocorre'.$cont1);
                                                $contexto = filter_input(INPUT_POST, 'contexto_ocorre'.$cont1.'_form');
                                                $sub_erro = filter_input(INPUT_POST, 'sub_erro_ocorre'.$cont1);
                                                
                                                $ext = strtolower(strrchr($nome_imagem_erro,"."));

                                                if(in_array($ext,$permitidos)){ //verifica se a extensão está entre as extensões permitidas                        
                                                    $tamanho = round($tamanho_imagem_erro / 1024);

                                                    if($tamanho < 1024){ //se imagem for até 1MB envia
                                                        $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem                            
                                                        $tmp = $_FILES['erro_img_ocorre'.$cont1]['tmp_name']; //caminho temporário da imagem
                                                        $caminho = $pasta.$nome_atual;

                                                        if(move_uploaded_file($tmp,$caminho)){
                                                            $insert_erro = mysqli_query($connect, "INSERT INTO tratamento (id_ocorrencia, tipo, tentativa, imagem, observacao, submissao) VALUES ('$id_ocorrencia', 'e', '$contexto','$caminho','$observacao_erro','$sub_erro')");
                                                            
                                                            if($insert_erro){
                                                                $cont2 = 1; //numero do tratamento da ocorrencia
                                                                while ($cont2<=10){

                                                                    if (isset($_FILES['tent_img'.$cont2.'_ocorre'.$cont1])) {

                                                                        $nome_imagem = $_FILES['tent_img'.$cont2.'_ocorre'.$cont1]['name'];
                                                                        $tamanho_imagem = $_FILES['tent_img'.$cont2.'_ocorre'.$cont1]['size'];
                                                                        $observacao = filter_input(INPUT_POST, 'tent'.$cont2.'_ocorre'.$cont1);
                                                                        $sub_tent = filter_input(INPUT_POST, 'sub_tent'.$cont2.'_ocorre'.$cont1);

                                                                        $ext = strtolower(strrchr($nome_imagem,"."));

                                                                        if(in_array($ext,$permitidos)){ //verifica se a extensão está entre as extensões permitidas                        
                                                                            $tamanho = round($tamanho_imagem / 1024);

                                                                            if($tamanho < 1024){ //se imagem for até 1MB envia
                                                                                $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem                            
                                                                                $tmp = $_FILES['tent_img'.$cont2.'_ocorre'.$cont1]['tmp_name']; //caminho temporário da imagem
                                                                                $caminho = $pasta.$nome_atual;

                                                                                if(move_uploaded_file($tmp,$caminho)){
                                                                                    $insert_tentativa = mysqli_query($connect, "INSERT INTO tratamento (id_ocorrencia, tipo, tentativa, imagem, observacao, submissao) VALUES ('$id_ocorrencia','t', '$cont2','$caminho','$observacao','$sub_tent')");

                                                                                }else{
                                                                                    //apaga ocorrencias anteriores e o equivoco 
                                                                                    $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha ao enviar imagem tentativa '.$cont2);
                                                                                }
                                                                            }else{
                                                                                //apaga ocorrencia1 e equivoco 
                                                                                $retornof = array('salvo'=>FALSE, 'mensag'=>'Tamanho máximo de 1MB da imagem excedido');
                                                                            }
                                                                        }else{
                                                                            //apaga ocorrencia1 e equivoco 
                                                                            $retornof = array('salvo'=>FALSE, 'mensag'=>'Formato de imagem não permitido');
                                                                        }
                                                                    }else{
                                                                        $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');
                                                                        break;
                                                                    }
                                                                    $cont2++;
                                                                }
                                                            }
                                                        }else{
                                                            //apaga ocorrencia1 e equivoco 
                                                            $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha ao enviar imagem tentativa '.$cont2);
                                                        }
                                                    }else{
                                                        //apaga ocorrencia1 e equivoco 
                                                        $retornof = array('salvo'=>FALSE, 'mensag'=>'Tamanho máximo de 1MB da imagem excedido');
                                                    }
                                                }else{
                                                    //apaga ocorrencia1 e equivoco 
                                                    $retornof = array('salvo'=>FALSE, 'mensag'=>'Formato de imagem não permitido');
                                                }
                                            }
                                    }else{
                                        //apagar o equivoco e sair
                                        $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha ao enviar ocorrência de exemplo');
                                    }
                                }else{
                                    break;
                                }
                                $cont1++;
                            }
                        }else{
                            $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha ao salvar equivoco');
                        }
                    }else{
                        $retornof = array('salvo'=>FALSE, 'mensag'=>'Falha ao enviar imagem de exemplo');
                    }
                }else{
                    $retornof = array('salvo'=>FALSE, 'mensag'=>'A imagem (exemplo) deve ser de no máximo 1MB');
                }
            }else{
                $retornof = array('salvo'=>FALSE, 'mensag'=>'O formato da imagem (exemplo) não é permitido');
            }
        }
    }else{
        $retornof = array('salvo'=>FALSE, 'mensag'=>'Selecione um arquivo para fazer upload');
    }
}else{
    //Formulario
    $titulo_form = trim(filter_input(INPUT_POST, 'titulo_form'));
    $tipo_form = filter_input(INPUT_POST, 'tipo_form');
    $linguagem_form = filter_input(INPUT_POST, 'linguagem_form');
    $conteudo_form = filter_input(INPUT_POST, 'conteudo_form');
    $corpo_form = filter_input(INPUT_POST, 'corpo_form');
    $contexto_form = filter_input(INPUT_POST, 'contexto_form');
    $id_solucao_prof_form = filter_input(INPUT_POST, 'nome_solucao_prof_form');   
    $id_solucao_aluno_form = filter_input(INPUT_POST, 'nome_solucao_aluno_form');
    
    
    //Banco de dados
    $select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_equivoco = '$id_form'") or die(mysql_error());
    $results = mysqli_fetch_array($select_equivoco);

    $titulo = $results['titulo'];

    $id_tipo = $results['id_tipo'];
    $id_linguagem = $results['id_linguagem'];
    $id_conteudo = $results['id_conteudo'];
    $id_solucao_prof = $results['id_solucao_professor'];
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
    
    //Comparações
    
    if(strcasecmp($titulo, $titulo_form) != 0){ //titulo
        $update_equivoco = mysqli_query($connect, "UPDATE equivoco SET titulo = '$titulo_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
    }
    if(strcasecmp($tipo, $tipo_form) != 0){ //tipo
        $select_tipo_form = mysqli_query($connect, "SELECT * FROM tipo WHERE nome_tipo = '$tipo_form'");
        $tipos = mysqli_fetch_array($select_tipo_form);
        $id_tipo_form = $tipos['id_tipo'];
        
        $update_equivoco_tipo = mysqli_query($connect, "UPDATE equivoco SET id_tipo = '$id_tipo_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
    }
    if(strcasecmp($lang, $linguagem_form) != 0){ //linguagem
        $select_linguagem = mysqli_query($connect, "SELECT * FROM linguagem WHERE nome_linguagem = '$linguagem_form'");
        $langs_form = mysqli_fetch_array($select_linguagem);
        $id_linguagem_form = $langs_form['id_linguagem'];
        
        $update_equivoco_lang = mysqli_query($connect, "UPDATE equivoco SET id_linguagem = '$id_linguagem_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
    }
    if(strcasecmp($conteudo, $conteudo_form) != 0){ //conteudo
        $select_conteudo_form = mysqli_query($connect, "SELECT * FROM conteudo WHERE nome_conteudo = '$conteudo_form'");
        $conteudos_form = mysqli_fetch_array($select_conteudo_form);
        $id_conteudo_form = $conteudos_form['id_conteudo'];
        
        $update_equivoco_conteudo = mysqli_query($connect, "UPDATE equivoco SET id_conteudo = '$id_conteudo_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
    } 
    if(strcasecmp($corpo, $corpo_form) != 0){ //corpo
        $update_equivoco_corpo = mysqli_query($connect, "UPDATE equivoco SET corpo = '$corpo_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
        
    }
    if(strcasecmp($id_solucao_prof, $id_solucao_prof_form) != 0){ //solucao para professor     
        $update_equivoco_contexto = mysqli_query($connect, "UPDATE equivoco SET id_solucao_professor = '$id_solucao_prof_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
        
    }
    if(strcasecmp($id_solucao_aluno, $id_solucao_aluno_form) != 0){ //solucao para aluno 
        $update_equivoco_contexto = mysqli_query($connect, "UPDATE equivoco SET id_solucao_aluno = '$id_solucao_aluno_form' WHERE id_equivoco = '$id_form'") or die(mysql_error());
        
    }
    
    // Ocorrencias 
    
    $cont1 = 1; //numero da ocorrencia
    while ($cont1<=4){
        //Formulario
        $id_aluno_form = filter_input(INPUT_POST, 'aluno_ocorre'.$cont1.'_form');
        $linguagem_ocorre_form = filter_input(INPUT_POST, 'lang_ocorre'.$cont1.'_form');
        $sub_total_form = filter_input(INPUT_POST, 'sub_ocorre'.$cont1.'_form');

        $select_linguagem = mysqli_query($connect, "SELECT * FROM linguagem WHERE nome_linguagem = '$linguagem_ocorre_form'"); //temporario, mudar value para id
        $langs_form = mysqli_fetch_array($select_linguagem);
        $id_linguagem_ocorre_form = $langs_form['id_linguagem'];
        
        if(($id_aluno_form != ('' || NULL) ) && ($linguagem_ocorre_form != ('' || NULL)) && ($sub_total_form != ('' || NULL))){
            $select_ocorrencia = mysqli_query($connect, "SELECT * FROM ocorrencia WHERE id_equivoco = '$id_form' AND ocorrencia = '$cont1'") or die(mysql_error());
            $existe_ocorrencia = mysqli_num_rows($select_ocorrencia);
            if($existe_ocorrencia){
                //Banco de dados
                $resul_ocorrencia = mysqli_fetch_array($select_ocorrencia);
                $id_ocorrencia = $resul_ocorrencia['id_ocorrencia'];
                $id_aluno = $resul_ocorrencia['id_aluno'];
                $id_linguagem_ocorre = $resul_ocorrencia['id_linguagem'];
                $sub_total = $resul_ocorrencia['sub_total'];

                //comparaçoes e Updates
                if(strcasecmp($id_linguagem_ocorre, $id_linguagem_ocorre_form) != 0){ 
                    $update_ocorre = mysqli_query($connect, "UPDATE ocorrencia SET id_linguagem = '$id_linguagem_ocorre_form' WHERE id_equivoco = '$id_form' AND ocorrencia = '$cont1'") or die(mysql_error());
                }
                if(strcasecmp($sub_total, $sub_total_form) != 0){ 
                    $update_ocorre = mysqli_query($connect, "UPDATE ocorrencia SET sub_total = '$sub_total_form' WHERE id_equivoco = '$id_form' AND ocorrencia = '$cont1'") or die(mysql_error());
                }
                if(strcasecmp($id_aluno, $id_aluno_form) != 0){ 
                    $update_ocorre = mysqli_query($connect, "UPDATE ocorrencia SET id_aluno = '$id_aluno_form' WHERE id_equivoco = '$id_form' AND ocorrencia = '$cont1'") or die(mysql_error());
                }
                
                //Tabela Tratamento (Erros e tentativas)
                $select_erro = mysqli_query($connect, "SELECT * FROM tratamento WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 'e'") or die(mysql_error());
                $existe_erro = mysqli_num_rows($select_erro);
                if($existe_erro){
                    //Banco de dados
                    $resul_erro = mysqli_fetch_array($select_erro);
                    $contexto_erro = $resul_erro['tentativa'];
                    $observacao_erro = $resul_erro['observacao'];
                    $submissao_erro = $resul_erro['submissao'];
                    
                    //Formulário
                    $observacao_erro_form = filter_input(INPUT_POST, 'erro_ocorre'.$cont1);
                    $contexto_erro_form = filter_input(INPUT_POST, 'contexto_ocorre'.$cont1.'_form');
                    $submissao_erro_form = filter_input(INPUT_POST, 'sub_erro_ocorre'.$cont1);
                    
                    //comparaçoes e Updates
                    if(strcasecmp($contexto_erro, $contexto_erro_form) != 0){ 
                        $update_erro = mysqli_query($connect, "UPDATE tratamento SET tentativa = '$contexto_erro_form' WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 'e'") or die(mysql_error());
                    }
                    if(strcasecmp($observacao_erro, $observacao_erro_form) != 0){ 
                        $update_erro = mysqli_query($connect, "UPDATE tratamento SET observacao = '$observacao_erro_form' WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 'e'") or die(mysql_error());
                    }
                    if(strcasecmp($submissao_erro, $submissao_erro_form) != 0){ 
                        $update_erro = mysqli_query($connect, "UPDATE tratamento SET submissao = '$submissao_erro_form' WHERE id_ocorrencia = '$id_ocorrencia' AND tipo = 'e'") or die(mysql_error());
                    }
                    
                }
            }
        }else{
            break;
        }
        $cont1++;
    }
            
    $retornof = array('salvo'=>TRUE, 'mensag'=>'Salvo com Sucesso!');    
}
$json_str = json_encode($retornof);
echo "$json_str";