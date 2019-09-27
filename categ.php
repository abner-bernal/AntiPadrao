<?php
    include("header.php");
    $id_lang= filter_input(INPUT_GET, 'id_lang');
    $id_tipo= filter_input(INPUT_GET, 'id_tipo');
    $opc = 0;
    $select_equivoco = 0;
    
    if(($id_lang && $id_tipo) != '' || ($id_lang && $id_tipo) != NULL){
        $opc = 1;
        $select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_linguagem = '$id_lang' AND id_tipo = '$id_tipo';");
    }else if($id_lang != '' || $id_lang != NULL){
        $opc = 2;
        $select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_linguagem = '$id_lang';");        
    }else if($id_tipo != '' || $id_tipo != NULL){
        $opc = 3;
        $select_equivoco = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_tipo = '$id_tipo';");
    }
    
    if(($opc == 1) || ($opc == 2)){
        $select_lang_nome = mysqli_query($connect, "SELECT * FROM linguagem WHERE id_linguagem = '$id_lang';");
        $langs = mysqli_fetch_array($select_lang_nome);
        $nome_lang = $langs['nome_linguagem'];
    }
    if(($opc == 1) || ($opc == 3)){
        $select_tipo_nome = mysqli_query($connect, "SELECT * FROM tipo WHERE id_tipo = '$id_tipo';");
        $tipos = mysqli_fetch_array($select_tipo_nome);
        $nome_tipo = $tipos['nome_tipo'];
    }
    
    $Nequivoco = mysqli_num_rows($select_equivoco);
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="window">
            <div class="menu-s">
                <div class="bar-side bar-s">
                    <a id="inicio" class="opc-start" href="index.php">Inicio</a>
                    <?php 
                        if((!isset ($_SESSION['email']) == true) and (!isset ($_SESSION['senha']) == true)){
                            echo '<a class="opc-start" href="signup.php">Cadastre-se</a>';
                        }else{
                            echo '<a class="opc-start" href="register-anti-padrao">Cadastrar Anti-padrão</a>';
                        }
                    ?>
                    <div class="bloc-side">
                        <div class="filt-bloc">
                            <div class="opc-title">
                                <span>Linguagem</span>
                            </div>                        
                            <div>
                                <?php                                     
                                    while ($lang = mysqli_fetch_array($select_lang)) {
                                        $nome_lang_opc = $lang['nome_linguagem'];
                                        $id_lang_opc = $lang['id_linguagem'];
                                        
                                        $select_equivoco_lang = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_linguagem = '$id_lang_opc';");
                                        $num_lang = mysqli_num_rows($select_equivoco_lang);
                                        
                                      echo '<div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" data-name="'.$nome_lang_opc.'" name="lang_filter" value="'.$id_lang_opc.'"';
                                                    if($id_lang_opc == $id_lang){
                                                        echo 'checked';
                                                    }
                                                echo '>
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">'.$nome_lang_opc.'</span>
                                                    <span class="filters-quantity">'.$num_lang.'</span>
                                                </label>
                                            </div>';
                                    }
                                ?>                         
                            </div>
                        </div>
                        <div class="filt-bloc">
                            <div class="opc-title">
                                <span>Tipo de Erro</span>
                            </div>                        
                            <div>
                                <?php                                    
                                    while ($tipo = mysqli_fetch_array($select_tipo)) {
                                        $nome_tipo_opc = $tipo['nome_tipo'];
                                        $id_tipo_opc = $tipo['id_tipo'];
                                        
                                        $select_equivoco_tipo = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_tipo = '$id_tipo_opc'");
                                        $num_tipo = mysqli_num_rows($select_equivoco_tipo);
                                        
                                      echo '<div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" data-name="'.$nome_tipo.'" name="tipo_filter" value="'.$id_tipo_opc.'"';
                                                    if($id_tipo_opc == $id_tipo){
                                                        echo 'checked';
                                                    }
                                                echo '>
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">'.$nome_tipo_opc.'</span>
                                                    <span class="filters-quantity">'.$num_tipo.'</span>
                                                </label>
                                            </div>';
                                    }
                                ?>                         
                            </div>
                        </div>
                        <div id="filters" class="filt-bloc">
                            <div class="opc-title">
                                <span>Filtros Ativos</span>
                            </div> 
                            <span class="tag-remov">
                                <span class="eva-3-tag lag <?php if(($opc == 1) || ($opc == 2)){ echo '-active';}?>">
                                    <span class="tag-text">Linguagem <?php echo $nome_lang;?></span>
                                    <i class="fas fa-times"></i>
                                </span>
                            </span><span class="tag-remov">
                                <span class="eva-3-tag tip <?php if(($opc == 1) || ($opc == 3)){ echo '-active';}?>">
                                    <span class="tag-text">Tipo <?php echo $nome_tipo;?></span>
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="cont">
                    <div id="content" class="cont1">
                        <?php 
                            if($opc == 1){
                              echo '<h2>Resultados</h2>';
                            }else if($opc == 2){
                              echo '<h2>
                                        <a href="categ.php?lang='.$id_lang.'">Linguagem '.$nome_lang.'</a>
                                    </h2>';
                            }else if($opc == 3){
                              echo '<h2>
                                        <a href="categ.php?tipo='.$id_tipo.'">Tipo '.$nome_tipo.'</a>
                                    </h2>';
                            }
                            if($Nequivoco == 0){
                                echo '<div>Nenhum Equivoco Encontrado</div>';
                            }
                        
                            while ($equivoco = mysqli_fetch_array($select_equivoco)) {
                                $id_equivoco = $equivoco['id_equivoco'];
                                $titulo_equivoco = $equivoco['titulo'];
                                $imagem_equivoco = $equivoco['imagem'];
                                
                               echo '<div class="uni-er">
                                         <a href="card.php?id='.$id_equivoco.'">
                                             <div class="box-er">
                                                <div class="box-img">
                                                    <div class="box-img2">
                                                        <img alt="" class="uni-img" src="'.$imagem_equivoco.'">
                                                    </div>
                                                </div>
                                                <div title="'.$titulo_equivoco.'" class="uni-title">'.$titulo_equivoco.'</div>
                                             </div>
                                         </a>
                                     </div>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>