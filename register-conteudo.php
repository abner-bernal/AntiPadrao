<?php
    include("header.php");
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="window">
            <div class="menu-s">
                <div class="bar-side bar-s">
                    <a class="opc-start" href="index.php">Inicio</a>
                    <a class="opc-start opc-selec" href="register-equivoco">Gerenciamento</a>
                    <div class="bloc-side">
                        <div class="filt-bloc">
                            <div class="opc-title">
                                <span>Gerenciar</span>
                            </div>
                            <a href="register-equivoco">
                                <div class="opc-start">Equivoco</div>
                            </a>
                            <a href="register-tipo">
                                <div class="opc-start">Tipo de Erro</div>
                            </a>
                            <a href="register-linguagem">
                                <div class="opc-start">Linguagem</div>
                            </a>
                            <a href="register-conteudo">
                                <div class="opc-start opc-selec">Conteúdo</div>
                            </a>
                            <a href="register-solucao">
                                <div class="opc-start">Solução</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="notify"></div>
                <div class="cont">
                    <div class="cont1">
                        <div class="bloc-card cad bloc-card-comp">
                            <h2 class="title-regis">Conteúdo</h2>
                            <div class="bloc-regis">
                                <form id="save_conteudo" enctype="multipart/form-data" method="POST" action="save/save-conteudo.php">
                                    <h2>Cadastrar</h2>
                                    <div class="regis-card">
                                        <div class="regis">
                                            <span class="card-title2">Conteúdo: </span>
                                            <input id="pesq-conteudo" type="text" name="conteudo_cad" value="" autocomplete="off">
                                            <span id="alert1" class="alert2"></span>
                                        </div>
                                        <div class="regis">
                                            <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                            <div id="opc-conteudo" class="regis-opc"></div>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <button id="button_save_conteudo" class="entra" type="submit">Cadastrar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="bloc-regis">
                                <form id="remove_conteudo" enctype="multipart/form-data" method="POST" action="../remove/remove-conteudo.php">
                                    <h2>Remover</h2>
                                    <div class="regis-card">
                                        <div class="regis">
                                            <span class="card-title2">Conteúdo: </span>
                                            <select name="conteudo_rem" class="select-cad">
                                                <option value="" ></option>
                                                <?php 
                                                    $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo");
                                                    while ($conteudo = mysqli_fetch_array($select_conteudo)){
                                                        $name_conteudo = $conteudo['nome_conteudo'];
                                                        echo '<option value="'.$name_conteudo.'">'.$name_conteudo.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <span id="alert2" class="alert2"></span>
                                            <button id="button_remove_conteudo" class="entra btn-remove" type="submit">Remover</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>