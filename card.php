<?php
    include("header.php");
    $id_card = filter_input(INPUT_GET, 'id');
    $selec_card = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_equivoco = $id_card");
    $cards = mysqli_fetch_array($selec_card);
    $titulo = $cards['titulo'];
    $id_tipo = $cards['id_tipo'];
    $id_linguagem = $cards['id_linguagem'];
    $id_conteudo = $cards['id_conteudo'];
    $corpo = $cards['corpo'];
    $imagem = $cards['imagem'];
    
    $select_tipo = mysqli_query($connect, "SELECT * FROM tipo WHERE id_tipo = '$id_tipo'") or die(mysql_error());
    $resul_tipo = mysqli_fetch_array($select_tipo);
    $tipo = $resul_tipo['nome_tipo'];

    $select_lang = mysqli_query($connect, "SELECT * FROM linguagem WHERE id_linguagem = '$id_linguagem'") or die(mysql_error());
    $resul_lang = mysqli_fetch_array($select_lang);
    $linguagem = $resul_lang['nome_linguagem'];

    $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo WHERE id_conteudo = '$id_conteudo'") or die(mysql_error());
    $resul_conteudo = mysqli_fetch_array($select_conteudo);
    $conteudo = $resul_conteudo['nome_conteudo'];
    
    $select_ocorrencia = mysqli_query($connect, "SELECT * FROM ocorrencia WHERE id_equivoco = '$id_card'") or die(mysql_error());
    
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="window">
            <div  class="menu-s">
                <div class="bar-side bar-s">
                    <a class="opc-start" href="index.php">Inicio</a>
                    <?php 
                        if((!isset ($_SESSION['email']) == true) and (!isset ($_SESSION['senha']) == true)){
                            echo '<a class="opc-start" href="signup.php">Cadastre-se</a>';
                        }else{
                            echo '<a class="opc-start" href="register-anti-padrao">Cadastrar Anti-padrão</a>';
                        }
                    ?>
                </div>
            </div>
            <div class="content">
                <div class="cont">
                    <div class="cont1">
                        <div class="bloc-card">
                            <div class="flex-r-around" style="line-height: 35px;">
                                <h2><?php echo $titulo;?></h2>
                            </div>
                            <div class="card2 card">
                                <div>
                                    <span>
                                        <span class="card-title2">Tipo de Erro: </span>
                                        <span><?php echo $tipo;?></span>
                                    </span>
                                    <span class="marg1-card">
                                        <span class="card-title2">Linguagem onde o erro ocorreu: </span>
                                        <span><?php echo $linguagem;?></span>
                                    </span>
                                </div>
                                <div>
                                    <span class="card-title2">Conteúdo: </span>
                                    <span><?php echo $conteudo;?></span>
                                </div>
                            </div>
                            <div class="card3 card">
                                <div class="card-title2">CORPO DO PROBLEMA: </div>
                                <div><?php echo $corpo;?></div>
                            </div>
                            <div class="card">
                                <div class="card-title2">exemplo: </div>
                                <div class="flex-r-around">
                                    <div>                                        
                                        <img alt="" class="uni-img" src="<?php echo $imagem;?>">
                                    </div>
                                    <div class="flex-c-center">
                                        <div>
                                            <span class="card-title2">id do Aluno:</span>
                                            <span><?php// echo $id_aluno;?></span>
                                        </div>
                                        <div>
                                            <span class="card-title2">linguagem:</span>
                                            <span><?php// echo $linguagem_exp;?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card5">
                                    <div class="card-title2">contexto do exemplo:</div>
                                    <div><?php// echo $contexto;?></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-title2">exemplo de como o erro foi tratado:</div>
                                <div class="card6">
                                    <?php 
                                    /*
                                        $selec_tentativas = mysqli_query($connect, "SELECT * FROM tratamento WHERE id_exemplo = $id_exemplo ORDER BY tentativa");
                                        while ($tentativa = mysqli_fetch_array($selec_tentativas)) {
                                            $n_tentativa = $tentativa['tentativa'];
                                            $observacao = $tentativa['observacao'];
                                            $tentativa_img = $tentativa['imagem'];
                                            
                                          echo '<div class="card6-1">
                                                    <div class="flex-r-around tent"><strong>'.$n_tentativa.'ª tentativa</strong></div>
                                                    <img alt="" class="uni-img" src="'.$tentativa_img.'">
                                                    <strong>Observação: </strong>
                                                    <span>'.$observacao.'</span>
                                                </div>';
                                        }*/
                                    ?>
                                </div>
                            </div>
                            <div></div>
                            <div class="card">
                                <div class="card-title2">solução:</div>
                                <div>
                                    <div style="line-height: 35px"><?php// echo $solucao;?></div>
                                    <?php /*
                                        $selec_passos = mysqli_query($connect, "SELECT * FROM passos WHERE id_anti_padrao = $id_card ORDER BY passo");
                                        while ($passo = mysqli_fetch_array($selec_passos)) {
                                            $n_passo = $passo['passo'];
                                            $descricao = $passo['descricao'];
                                            
                                          echo '<div class="padd-soluc">
                                                    <strong>'.$n_passo.'.</strong>
                                                    <span>'.$descricao.'</span>
                                                </div>';
                                        }*/
                                    ?>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-title2">ligações com outros padrões:</div>
                                <div><?php //echo $ligacao;?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>