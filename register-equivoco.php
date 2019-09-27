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
                                <div class="opc-start opc-selec">Equívoco</div>
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
                                <div class="opc-start">Solução</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">                
                <div class="cont">
                    <div class="cont1">
                        <form id="save_equivoco" enctype="multipart/form-data" method="POST" action="save-equivoco.php">
                            <div class="bloc-top-buttons">
                                <div class="bloc-buttons">
                                    <div class="">
                                        <span id="muda-equivoco">Equívoco:</span><span id="title-top"></span>
                                    </div>
                                    <div class="">
                                        <span>ID:</span><span id="id-top"></span>
                                    </div>
                                    <div>
                                        <button id="button_delete_equivoco" class="apagar" type="button" disabled>Apagar</button>
                                        <button id="button_save_equivoco" class="salvar" type="submit">Salvar</button>
                                    </div>
                                </div>
                                <div class="bloc-buttons2"></div>
                            </div>
                            <div class="bloc-card cad">                                                        
                                <div class="bloc-regis"> 
                                <div>
                                    <div class="card card1">
                                        <div>
                                            <span class="card-title2">título: </span>
                                            <input id="pesq-equivoco" class="campo-regis" type="text" name="titulo_form" value="" autocomplete="off" required>
                                            <span class="card-title2">id:</span><input class="campo-id" type="text" name="id_form" value="" readonly>
                                            <span id="alert1" class="alert2"></span>
                                            <span id="button-pesq" class="btn-pesq">
                                                <img class="btn-pesq-img" src="images/lupa.svg">
                                            </span>
                                        </div>
                                        <div class="card-novo">
                                            <div id="bloc-pesq-equivoco" class="bloc-novo">
                                                <div class="padd-novo">
                                                    <div>
                                                        <div class="regis flex-r-between">
                                                            <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                            <div>
                                                                <span class="card-title2">ID: </span>
                                                                <input class="campo-regis" id="pesq-id" type="text" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div id="opc-equivoco" class=""></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card2">
                                        <div>
                                            <div>
                                                <span class="card-title2">Tipo de Erro: </span>
                                                <select name="tipo_form" class="select-cad" required>
                                                    <option value="" ></option>
                                                    <?php 
                                                        $select_tipo = mysqli_query($connect, "SELECT * FROM tipo");
                                                        while ($tipo = mysqli_fetch_array($select_tipo)){
                                                            $name_tipo = $tipo['nome_tipo'];
                                                            echo '<option value="'.$name_tipo.'">'.$name_tipo.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <span id="novo-tipo" class="btn-novo">                                                    
                                                    <span>Adicionar</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                            <div class="card-novo">
                                                <div id="bloc-novo-tipo" class="bloc-novo">
                                                    <div class="padd-novo">
                                                        <div>
                                                            <div class="regis">
                                                                <span class="card-title2">Tipo de Erro: </span>
                                                                <input class="campo-regis" id="pesq-tipo" type="text" value="" autocomplete="off">
                                                                <span id="alert2" class="alert2"></span>
                                                            </div>
                                                            <div class="regis">
                                                                <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                                <div id="opc-tipo" class="regis-opc"></div>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <span id="button_novo_tipo" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <span class="card-title2">Linguagem: </span>
                                                <select name="linguagem_form" class="select-cad" required>
                                                    <option value="" ></option>
                                                    <?php 
                                                        $select_lang = mysqli_query($connect, "SELECT * FROM linguagem");
                                                        while ($lang = mysqli_fetch_array($select_lang)){
                                                            $name_lang = $lang['nome_linguagem'];
                                                            echo '<option value="'.$name_lang.'">'.$name_lang.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <span id="novo-linguagem" class="btn-novo">
                                                    <span>Adicionar</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                            <div class="card-novo">
                                                <div id="bloc-novo-linguagem" class="bloc-novo">
                                                    <div class="padd-novo">
                                                        <div>
                                                            <div class="regis">
                                                                <span class="card-title2">Linguagem: </span>
                                                                <input class="campo-regis" id="pesq-lang" type="text" value="" autocomplete="off">
                                                                <span id="alert3" class="alert2"></span>
                                                            </div>
                                                            <div class="regis">
                                                                <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                                <div id="opc-linguagem" class="regis-opc"></div>
                                                            </div>
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <span id="button_novo_linguagem" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <span class="card-title2">Conteúdo: </span>
                                                <select name="conteudo_form" class="select-cad" required>
                                                    <option value="" ></option>
                                                    <?php 
                                                        $select_conteudo = mysqli_query($connect, "SELECT * FROM conteudo");
                                                        while ($conteudo = mysqli_fetch_array($select_conteudo)){
                                                            $name_conteudo = $conteudo['nome_conteudo'];
                                                            echo '<option value="'.$name_conteudo.'">'.$name_conteudo.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <span id="novo-conteudo" class="btn-novo">
                                                    <span>Adicionar</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
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
                                                            <span id="button_novo_conteudo" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card3">
                                        <div class="card-title2">CORPO DO PROBLEMA: </div>
                                        <div>
                                            <textarea name="corpo_form" required></textarea>
                                        </div>
                                    </div>
                                    <div id="evento1" class="card card5 card4">
                                        <div class="card-title2">exemplo:</div>
                                        <div class="flex-r-around">
                                            <div class="flex-c-center">
                                                <input type="file" accept="image/*" name="img_exemplo_form">
                                            </div>
                                            <div>
                                                <div class="mg-btm">
                                                    <span class="card-title2">id do Aluno:</span>
                                                    <input class="campo-regis" type="text" name="aluno_ocorre1_form" value="" autocomplete="off" required>
                                                </div>                                                
                                                <div class="mg-btm">
                                                    <span class="card-title2">linguagem:</span>
                                                    <select name="lang_ocorre1_form" class="select-cad" required>
                                                        <option value="" ></option>
                                                        <?php
                                                            $select_lang = mysqli_query($connect, "SELECT * FROM linguagem");
                                                            while ($lang = mysqli_fetch_array($select_lang)){
                                                                $name_lang = $lang['nome_linguagem'];
                                                                echo '<option value="'.$name_lang.'">'.$name_lang.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mg-btm">
                                                    <span class="card-title2">Total de Submissão:</span>
                                                    <input class="campo-regis" type="number" min="1" name="sub_ocorre1_form" value="" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>                                      
                                        <div>
                                            <div class="card-title2">contexto do exemplo:</div>
                                            <div>
                                                <textarea name="contexto_ocorre1_form" required></textarea>
                                            </div>
                                        </div>
                                        <div id="tentativas" class="card6">
                                            <div class="card6-1">
                                                <div class="tent">
                                                    <strong>ERRO</strong>
                                                </div>
                                                <div>
                                                    <input type="file" class="space-input" accept="image/*" name="erro_img_ocorre1">
                                                </div>
                                                <div>
                                                    <strong class="card-title2">Submissão:</strong><input class="campo-regis" type="number" min="1" name="sub_erro_ocorre1" value="" autocomplete="off">
                                                </div>
                                                <div class="tent">
                                                    <strong>Observação:</strong>
                                                </div>
                                                <div>
                                                    <textarea name="erro_ocorre1"></textarea>
                                                </div>                                                
                                            </div>
                                            <div data-ord="1" class="card6-1">
                                                <div class="tent">
                                                    <strong>1ª tentativa</strong>
                                                </div>
                                                <div>
                                                    <input type="file" class="space-input" accept="image/*" name="tent_img1_ocorre1">
                                                </div>
                                                <div>
                                                    <strong class="card-title2">Submissão:</strong><input class="campo-regis" type="number" min="1" name="sub_tent1_ocorre1" value="" autocomplete="off">
                                                </div>
                                                <div class="tent">
                                                    <strong>Observação:</strong>
                                                </div>
                                                <div>
                                                    <textarea name="tent1_ocorre1"></textarea>
                                                </div>                                                
                                            </div>
                                            <div class="adc-tent">
                                                <span data-ocorre="1" class="btn-novo adc-tentativa">
                                                    <span>Adicionar tentativa</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card7">
                                        <div class="card-title2">outras ocorrências do mesmo erro:</div>
                                        <div>
                                            <div class="card-title3">
                                                <span>Ocorrência 2:</span>
                                                <span id="novo-ocorrencia" class="btn-novo">                                                    
                                                    <span>Adicionar</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                            <div id="bloc-novo-ocorrencia" class="bloc-novo">
                                                <div class="padd-novo">
                                                    <div class="flex-r-around">
                                                        <div class="mg-btm">
                                                            <span class="card-title2">Total de Submissão:</span>
                                                            <input class="campo-regis" type="number" min="1" name="sub_ocorre2_form" value="" autocomplete="off">
                                                        </div>                                                        
                                                        <div class="mg-btm">
                                                            <span class="card-title2">linguagem:</span>
                                                            <select name="lang_ocorre2_form" class="select-cad">
                                                                <option value="0" ></option>
                                                                <?php
                                                                    $select_lang = mysqli_query($connect, "SELECT * FROM linguagem");
                                                                    while ($lang = mysqli_fetch_array($select_lang)){
                                                                        $name_lang = $lang['nome_linguagem'];
                                                                        echo '<option value="'.$name_lang.'">'.$name_lang.'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>                                                        
                                                    </div>
                                                    <div class="flex-r-around">
                                                        <div class="mg-btm">
                                                            <span class="card-title2">id do Aluno:</span>
                                                            <input class="campo-regis" type="text" name="aluno_ocorre2_form" value="" autocomplete="off">
                                                        </div>                                                        
                                                    </div>
                                                    <div>
                                                        <div class="card-title2">contexto da ocorrência:</div>
                                                        <div>
                                                            <textarea name="contexto_ocorre2_form"></textarea>
                                                        </div>
                                                    </div>
                                                    <div id="tentativas_ocorre2" class="card6 card5">
                                                        <div class="card6-1">
                                                            <div class="tent">
                                                                <strong>ERRO</strong>
                                                            </div>
                                                            <div>
                                                                <input type="file" class="space-input" accept="image/*" name="erro_img_ocorre2">
                                                            </div> 
                                                            <div class="mg-btm">
                                                                <strong class="card-title2">Submissão:</strong><input class="campo-regis" type="number" min="1" name="sub_erro_ocorre2" value="" autocomplete="off">
                                                            </div>
                                                            <div class="tent">
                                                                <strong>Observação:</strong>
                                                            </div>
                                                            <div>
                                                                <textarea name="erro_ocorre2"></textarea>
                                                            </div>                                                
                                                        </div>
                                                        <div data-ord="1" class="card6-1">
                                                            <div class="tent">
                                                                <strong>1ª tentativa</strong>
                                                            </div>
                                                            <div>
                                                                <input type="file" class="space-input" accept="image/*" name="tent_img1_ocorre2">
                                                            </div>
                                                            <div class="mg-btm">
                                                                <strong class="card-title2">Submissão:</strong><input class="campo-regis" type="number" min="1" name="sub_tent1_ocorre2" value="" autocomplete="off">
                                                            </div>
                                                            <div class="tent">
                                                                <strong>Observação:</strong>
                                                            </div>
                                                            <div>
                                                                <textarea name="tent1_ocorre2"></textarea>
                                                            </div>                                                
                                                        </div>
                                                        <div class="adc-tent">
                                                            <span data-ocorre="2" class="btn-novo adc-tentativa">
                                                                <span>Adicionar tentativa</span>
                                                                <img class="smb-novo" src="images/mais.svg">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="obs">*Será adicionado assim que o equívoco for salvo</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card8">
                                        <div class="card-title2 mg-btm">solução para professor:</div>
                                        <div>
                                            <div>
                                                <span class="card-title2">Nome: </span>
                                                <select name="nome_solucao_prof_form" class="select-cad">
                                                    <option value="0" ></option>
                                                    <?php 
                                                        $select_solucao_prof = mysqli_query($connect, "SELECT * FROM solucao WHERE alvo = 'professor'");
                                                        while ($solucao_prof = mysqli_fetch_array($select_solucao_prof)){
                                                            $nome_solucao = $solucao_prof['nome_solucao'];
                                                            $id_solucao = $solucao_prof['id_solucao'];
                                                            
                                                            echo '<option value="'.$id_solucao.'">'.$nome_solucao.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <span id="novo-solucao-prof" class="btn-novo">                                                    
                                                    <span>Adicionar Solução</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                            <div class="card-novo">
                                                <div id="bloc-novo-solucao-prof" class="bloc-novo">
                                                    <div class="padd-novo">
                                                        <div class="card card1 solu1">
                                                            <div class="mg-btm">
                                                                <span class="card-title2">nome: </span>
                                                                <input id="pesq-solucao-equivoco" class="campo-regis" type="text" name="nome_form_solucao" value="" autocomplete="off">
                                                                <span id="alert16" class="alert2"></span>
                                                            </div>
                                                            <div class="regis">
                                                                <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                                <div id="opc-solucao" class="regis-opc"></div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-title2 mg-btm">solução para:</div>
                                                            <div>
                                                                <div class="opc">
                                                                    <label class="pos-rel">
                                                                        <input type="radio" class="checkbox-tag" name="alvo_form_solucao_prof" value="professor">
                                                                        <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                                            <i class="mark"></i>
                                                                        </i>
                                                                        <span class="opc-font">professor</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card card8 solu3">
                                                            <div class="card-title2 mg-btm">descrição:</div>
                                                            <div>
                                                                <div>
                                                                    <textarea name="descricao_form_solucao_prof"></textarea>
                                                                </div>
                                                                <div class="padd-soluc">
                                                                    <strong>Passos (Opcional):</strong>
                                                                </div>
                                                                <div id="passos-prof-form">
                                                                    <div data-ord="1" class="padd-soluc">
                                                                        <strong>1.</strong><input class="campo-regis" type="text" name="passo_form_solucao_prof[]" value="" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="padd-soluc adc-passo">
                                                                    <strong>2.</strong><span id="adc-passo-prof" class="btn-novo">
                                                                        <span>Adicionar passo</span><img class="smb-novo" src="images/mais.svg"></span><span class="alert1"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card solu4">
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
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <span id="button_novo_solucao" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="card-title3">descrição:</div>
                                            <div>
                                                <textarea name="solucao_prof_form" class="inativo" readonly></textarea>
                                            </div>
                                            <div class="padd-soluc">
                                                <strong>Passos:</strong>
                                            </div>
                                            <div id="passos-prof">
                                                <div data-ord="1" class="padd-soluc">
                                                    <strong>1.</strong><input class="campo-regis inativo" type="text" name="passo1_prof" value="" autocomplete="off" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card8">
                                        <div class="card-title2 mg-btm">solução para aluno:</div>
                                        <div>
                                            <div>
                                                <span class="card-title2">Nome: </span>
                                                <select name="nome_solucao_aluno_form" class="select-cad">
                                                    <option value="0" ></option>
                                                    <?php 
                                                        $select_solucao_aluno = mysqli_query($connect, "SELECT * FROM solucao WHERE alvo = 'aluno'");
                                                        while ($solucao_aluno = mysqli_fetch_array($select_solucao_aluno)){
                                                            $nome_solucao = $solucao_aluno['nome_solucao'];
                                                            $id_solucao = $solucao_aluno['id_solucao'];
                                                            
                                                            echo '<option value="'.$id_solucao.'">'.$nome_solucao.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <span id="novo-solucao-aluno" class="btn-novo">                                                    
                                                    <span>Adicionar Solução</span>
                                                    <img class="smb-novo" src="images/mais.svg">
                                                </span>
                                            </div>
                                            <div class="card-novo">
                                                <div id="bloc-novo-solucao-aluno" class="bloc-novo">
                                                    <div class="padd-novo">
                                                        <div class="card card1 solu1">
                                                            <div class="mg-btm">
                                                                <span class="card-title2">nome: </span>
                                                                <input id="pesq-solucao-equivoco-aluno" class="campo-regis" type="text" name="nome_form_solucao_aluno" value="" autocomplete="off">
                                                                <span id="alert16" class="alert2"></span>
                                                            </div>
                                                            <div class="regis">
                                                                <div class="card-title2 regis-cadastrados">Cadastrados: </div>
                                                                <div id="opc-solucao" class="regis-opc"></div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-title2 mg-btm">solução para:</div>
                                                            <div>
                                                                <div class="opc">
                                                                    <label class="pos-rel">
                                                                        <input type="radio" class="checkbox-tag" name="alvo_form_solucao_aluno" value="aluno">
                                                                        <i class="checkbox-check eva-3-icon-checkmark filters-checkbox-left">
                                                                            <i class="mark"></i>
                                                                        </i>
                                                                        <span class="opc-font">aluno</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card card8 solu3">
                                                            <div class="card-title2 mg-btm">descrição:</div>
                                                            <div>
                                                                <div>
                                                                    <textarea name="descricao_form_solucao_aluno"></textarea>
                                                                </div>
                                                                <div class="padd-soluc">
                                                                    <strong>Passos (Opcional):</strong>
                                                                </div>
                                                                <div id="passos-aluno-form">
                                                                    <div data-ord="1" class="padd-soluc">
                                                                        <strong>1.</strong><input class="campo-regis" type="text" name="passo_form_solucao_aluno[]" value="" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="padd-soluc adc-passo">
                                                                    <strong>2.</strong><span id="adc-passo-aluno" class="btn-novo">
                                                                        <span>Adicionar passo</span><img class="smb-novo" src="images/mais.svg"></span><span class="alert1"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card solu4">
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
                                                        </div>
                                                        <div style="text-align: right;">
                                                            <span id="button_novo_solucao_aluno" class="novo">Cadastrar</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="card-title3">descrição:</div>
                                            <div>
                                                <textarea name="solucao_aluno_form" class="inativo" readonly></textarea>
                                            </div>
                                            <div class="padd-soluc">
                                                <strong>Passos:</strong>
                                            </div>
                                            <div id="passos-aluno">
                                                <div data-ord="1" class="padd-soluc">
                                                    <strong>1.</strong><input class="campo-regis inativo" type="text" name="passo1_aluno" value="" autocomplete="off" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card9">
                                        <div class="card-title2">ligações com outros padrões:</div>
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