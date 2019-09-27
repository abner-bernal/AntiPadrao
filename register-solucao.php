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
                                <div class="opc-start">Conteúdo</div>
                            </a>
                            <a href="register-solucao">
                                <div class="opc-start opc-selec">Solução</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="notify"></div>
                <div class="cont">
                    <div class="cont1">
                        <form id="save_solucao" enctype="multipart/form-data" method="POST" action="save/save-solucao.php">
                            <div class="bloc-top-buttons">
                                <div class="bloc-buttons">
                                    <div>
                                        <span>Solução:</span><span id="nome-top"></span>
                                    </div>
                                    <div>
                                        <button id="button_delete_solucao" class="apagar" type="button" disabled>Apagar</button>
                                        <button id="button_save_solucao" class="salvar" type="submit">Salvar</button>
                                    </div>
                                </div>
                                <div class="bloc-buttons2"></div>
                            </div>
                            <div class="bloc-card cad">
                                <div class="bloc-regis">
                                    <div class="card card1">
                                        <div>
                                            <span class="card-title2">nome: </span>
                                            <input id="pesq-solucao" class="campo-regis" type="text" name="nome_form_solucao" value="" autocomplete="off" required>
                                            <span class="card-title2">id:</span><input class="campo-id" type="text" name="id_form_solucao" value="" readonly>
                                            <span id="alert1" class="alert2"></span>
                                            <span id="button-pesq-solucao" class="btn-pesq">
                                                <img class="btn-pesq-img" src="images/lupa.svg">
                                            </span>
                                        </div>
                                        <div class="card-novo">
                                            <div id="bloc-pesq-solucao" class="bloc-novo">
                                                <div class="padd-novo">
                                                    <div>
                                                        <div class="regis flex-r-between">
                                                            <div>
                                                                <span class="card-title2">Conteúdo: </span>
                                                                <select name="conteudo_form_solucao" class="select-cad">
                                                                    <option value="" ></option>
                                                                    <?php 
                                                                        $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo");
                                                                        while ($conteudo = mysqli_fetch_array($select_conteudo)){
                                                                            $name_conteudo = $conteudo['nome_conteudo'];
                                                                            $id_conteudo = $conteudo['id_conteudo'];
                                                                            echo '<option value="'.$id_conteudo.'">'.$name_conteudo.'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div style="text-align: right">
                                                                <span class="card-title2">ID: </span>
                                                                <input class="campo-regis" id="pesq-id-solucao" type="text" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div id="opc-solucao" class=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-title2 mg-btm">solução para:</div>
                                        <div>
                                            <div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" name="alvo_form_solucao" value="professor">
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">professor</span>
                                                </label>
                                            </div>
                                            <div class="opc">
                                                <label class="pos-rel">
                                                    <input type="radio" class="checkbox-tag" name="alvo_form_solucao" value="aluno">
                                                    <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                        <i class="mark"></i>
                                                    </i>
                                                    <span class="opc-font">aluno</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card8">
                                        <div class="card-title2">descrição:</div>
                                        <div>
                                            <div>
                                                <textarea name="descricao_form_solucao" required></textarea>
                                            </div>
                                            <div class="padd-soluc">
                                                <strong>Passos (Opcional):</strong>
                                            </div>
                                            <div id="passos-solucao">
                                                <div data-ord="1" class="padd-soluc">
                                                    <strong>1.</strong><input class="campo-regis" type="text" name="passo1_form_solucao" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="padd-soluc adc-passo">
                                                <strong>2.</strong><span id="adc-passo-solucao" class="btn-novo">
                                                    <span>Adicionar passo</span><img class="smb-novo" src="images/mais.svg"></span><span class="alert1"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-title2 mg-btm">relações com conteúdo:</div>
                                        <div id="relacoes_cont_solucao">
                                        <?php
                                            $select_conteudo_check = mysqli_query($connect, "SELECT * FROM conteudo");
                                            
                                            while ($conteudo = mysqli_fetch_array($select_conteudo_check)){
                                                $name_conteudo = $conteudo['nome_conteudo'];
                                                $id_conteudo = $conteudo['id_conteudo'];
                                                
                                              echo '<div class="opc">
                                                        <label class="cont-rel">
                                                            <input type="checkbox" class="checkbox-tag" name="conteudo_relacao[]" value="'.$id_conteudo.'">
                                                            <i class="checkbox filters-checkbox-left">
                                                                <i class="mark-check"></i>
                                                            </i>
                                                            <span class="opc-font">'.$name_conteudo.'</span>
                                                        </label>
                                                    </div>';
                                            }
                                        ?>
                                        </div>
                                        <div>                                            
                                            <div class="card-novo">
                                                <div id="bloc-novo-conteudo" class="bloc-novo">
                                                    <div class="padd-novo">
                                                        <div>
                                                            <div class="regis">
                                                                <span class="card-title2">Conteúdo: </span>
                                                                <input class="campo-regis" id="pesq-conteudo" type="text" value="" autocomplete="off">
                                                                <span id="alert4" class="alert2"></span>
                                                            </div>
                                                            <div class="regis">
                                                                <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                                <div id="opc-conteudo" class="regis-opc"></div>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <span id="button_novo_conteudo_solucao" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <span id="novo-conteudo" class="btn-novo">
                                                    <span>Adicionar Conteúdo</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>