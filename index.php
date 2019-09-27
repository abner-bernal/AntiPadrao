<?php
    include("header.php");
    
    $verif = FALSE;
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="window">
            <div class="menu-s">
                <div class="bar-side bar-s">
                    <a id="inicio" class="opc-start opc-selec" href="index.php">Inicio</a>
                     <?php 
                        if((!isset ($_SESSION['email']) == true) and (!isset ($_SESSION['senha']) == true)){
                            echo '<a  class="opc-start" href="signup.php">Cadastre-se</a>';
                        }else{
                            echo '<a class="opc-start" href="register-equivoco">Gerenciamento</a>';
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
                                        $nome_lang = $lang['nome_linguagem'];
                                        $id_lang = $lang['id_linguagem'];
                                        
                                        $select_equivoco_lang = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_linguagem = '$id_lang';");
                                        $num_lang = mysqli_num_rows($select_equivoco_lang);
                                        
                                      echo '<div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" data-name="'.$nome_lang.'" name="lang_filter" value="'.$id_lang.'">
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">'.$nome_lang.'</span>
                                                    <span class="filters-quantity">'.$num_lang.'</span>
                                                </label>
                                            </div>';
                                    }
                                ?>
                        </div>
                        <div class="filt-bloc">
                            <div class="opc-title">
                                <span>Tipo de Erro</span>
                            </div>                        
                            <div>
                                <?php                                    
                                    while ($tipo = mysqli_fetch_array($select_tipo)) {
                                        $nome_tipo = $tipo['nome_tipo'];
                                        $id_tipo = $tipo['id_tipo'];
                                        
                                        $select_equivoco_tipo = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_tipo = '$id_tipo'");
                                        $num_tipo = mysqli_num_rows($select_equivoco_tipo);
                                        
                                      echo '<div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" data-name="'.$nome_tipo.'" name="tipo_filter" value="'.$id_tipo.'">
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">'.$nome_tipo.'</span>
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
                                <span class="eva-3-tag lag">
                                    <span class="tag-text"></span>
                                    <i class="fas fa-times"></i>
                                </span>
                            </span><span class="tag-remov">
                                <span class="eva-3-tag tip">
                                    <span class="tag-text"></span>
                                    <i class="fas fa-times"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
                <div class="content">
                    <div class="cont">
                        <div id="content" class="cont1">
                            <?php
                                $select_lang_cont = mysqli_query($connect, "SELECT * FROM linguagem");
                                while ($lang = mysqli_fetch_array($select_lang_cont)) {
                                        $nome_lang = $lang['nome_linguagem'];
                                        $id_lang = $lang['id_linguagem'];
                                        
                                        $select_equivoco_lang = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_linguagem = '$id_lang'");
                                        $num_lang = mysqli_num_rows($select_equivoco_lang);
                                        if($num_lang > 0){
                                            echo '<h2>
                                                      <a href="categ.php?id_lang='.$id_lang.'">Linguagem '.$nome_lang.'</a>
                                                  </h2>
                                                  <div class="top_bar">
                                                      <div class="list-desl desl-l left-desl">
                                                          <div class="list-deslN">
                                                              <button class="button-list" aria-label="Proximo">
                                                                  <img src="images/setaL.svg" class="seta" style="margin-left: -1px">
                                                              </button>
                                                          </div>                                
                                                      </div>
                                                      <div id="deslize" class="line-er">
                                                          <div id="itens1" class="line1 itens" style="transform: translateX(0px);">';



                                            while ($equivoco_lang = mysqli_fetch_array($select_equivoco_lang)) {
                                                  $id_equivoco = $equivoco_lang['id_equivoco'];
                                                  $titulo_equivoco = $equivoco_lang['titulo'];
                                                  $img_equivoco = $equivoco_lang['imagem'];

                                                      echo '<div class="uni-er">
                                                                <a href="card.php?id='.$id_equivoco.'">
                                                                    <div class="box-er">
                                                                        <div class="box-img">
                                                                            <div class="box-img2">
                                                                                <img alt="" class="uni-img" src="'.$img_equivoco.'">
                                                                            </div>
                                                                        </div>
                                                                        <div title="'.$titulo_equivoco.'" class="uni-title">'.$titulo_equivoco.'</div>
                                                                    </div>
                                                                </a>
                                                            </div>';
                                              }                                    
                                                  echo '</div>
                                                          </div>
                                                          <div class="list-desl desl-r right-desl">
                                                              <div class="list-deslN">
                                                                  <button class="button-list" aria-label="Proximo">
                                                                      <img src="images/setaR.svg" class="seta" style="margin-right: -1px">
                                                                  </button>
                                                              </div>                                
                                                          </div>    
                                                      </div>';
                                        }
                                }
                                $select_tipo_cont = mysqli_query($connect, "SELECT * FROM tipo");
                                
                                while ($tipo = mysqli_fetch_array($select_tipo_cont)) {
                                    $nome_tipo = $tipo['nome_tipo'];
                                    $id_tipo = $tipo['id_tipo'];                                       

                                    $select_equivoco_tipo = mysqli_query($connect, "SELECT * FROM equivoco WHERE id_tipo = '$id_tipo'");
                                    $num_tipo = mysqli_num_rows($select_equivoco_tipo);
                                    if($num_tipo > 0){
                                        echo '<h2>
                                                  <a href="categ.php?id_tipo='.$id_tipo.'">Tipo de Erro '.$nome_tipo.'</a>
                                              </h2>
                                              <div class="top_bar">
                                                  <div class="list-desl desl-l left-desl">
                                                      <div class="list-deslN">
                                                          <button class="button-list" aria-label="Proximo">
                                                              <img src="images/setaL.svg" class="seta" style="margin-left: -1px">
                                                          </button>
                                                      </div>                                
                                                  </div>
                                                  <div id="deslize" class="line-er">
                                                      <div id="itens1" class="line1 itens" style="transform: translateX(0px);">';



                                        while ($equivoco_tipo = mysqli_fetch_array($select_equivoco_tipo)) {
                                              $id_equivoco = $equivoco_tipo['id_equivoco'];
                                              $titulo_equivoco = $equivoco_tipo['titulo'];
                                              $img_equivoco = $equivoco_tipo['imagem'];

                                                  echo '<div class="uni-er">
                                                            <a href="card.php?id='.$id_equivoco.'">
                                                                <div class="box-er">
                                                                    <div class="box-img">
                                                                        <div class="box-img2">
                                                                            <img alt="" class="uni-img" src="'.$img_equivoco.'">
                                                                        </div>
                                                                    </div>
                                                                    <div title="'.$titulo_equivoco.'" class="uni-title">'.$titulo_equivoco.'</div>
                                                                </div>
                                                            </a>
                                                        </div>';
                                          }                                    
                                              echo '</div>
                                                      </div>
                                                      <div class="list-desl desl-r right-desl">
                                                          <div class="list-deslN">
                                                              <button class="button-list" aria-label="Proximo">
                                                                  <img src="images/setaR.svg" class="seta" style="margin-right: -1px">
                                                              </button>
                                                          </div>                                
                                                      </div>    
                                                  </div>';
                                    }
                                }
                            ?>
                    </div>
                </div> 
            </div>
        </div>
    </body>
</html>