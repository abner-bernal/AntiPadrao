<?php    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    include("db.php");
    /*require_once('config.php');
    require_once('i18n.php');*/
    
    $select_lang = mysqli_query($connect, "SELECT * FROM linguagem");
    $select_tipo = mysqli_query($connect, "SELECT * FROM tipo");
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Anti-padrões</title>
        <link href="fontawesome/css/all.css" rel="stylesheet">
        <link href="css/styles.css?version=51" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-3.3.1"></script>
        
        <script defer type="text/javascript" src="js/global.js?version=36"></script>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript">
            $(document).ready(function () {
                // Adicionar classes ao carregar o documento
                contsize();
                for(var i=1;i<5;i++){
                    quantitens(i);
                }
            });
            $(window).resize(function() {
                // Adicionar sempre que a tela for redimensionada
                contsize();
                for(var i=1;i<5;i++){
                    quantitens(i);
                }
            });
            
        </script>
    </head>
    <body>
        <div class="notify"></div>
        <div class="top_bar bar">            
            <div class="menu_bar bar">
                <div style="margin-left: 25px;">
                    <?php 
                        if((!isset ($_SESSION['email']) == true) and (!isset ($_SESSION['senha']) == true)){
                            unset($_SESSION['email']);
                            unset($_SESSION['senha']);
                            unset($_SESSION['nome']);
                      echo '<form id="entrar" method="POST" action="login.php">
                                <table cellspacing="0">
                                    <tr>
                                        <td>
                                            <input placeholder="E-mail" class="inputtext" type="email" name="email">
                                        </td>
                                        <td>
                                            <input placeholder="Senha" class="inputtext" type="password" name="senha">
                                        </td>
                                        <td>
                                            <button class="entra" type="submit">Entrar</button> 
                                        </td>
                                        <td>
                                            <a class="font-p">Esqueceu a senha?</a>
                                        </td>
                                    </tr>
                                </table>
                            </form>';
                        }else{
                           $nome = $_SESSION['nome'];
                    echo '<div class="menu_emp _3HsQj">
                              <a class="_3ROGm" href="">
                                      <img alt="" class="pic-bar pic-bar-img" src="images/f2.png">
                              </a>
                              <span class="menu_emp_name">'.$nome.'</span>
                              <ul class="_3q7Wh OSaWc _2HujR _1ZY-H">
                                  <li class="_31ObI">
                                      <a id="settings" class="_3sWvR" href="">Perfil</a>
                                  </li>
                                  <li class="_31ObI">
                                      <a id="settings" class="_3sWvR" href="">Configurações</a>
                                  </li>
                                  <div class="line"></div>
                                  <li class="_31ObI">
                                      <span class="_3sWvR" id="sair">Sair</span>
                                  </li>
                              </ul>
                          </div>';
                        }
                    
                    ?>
                    
                </div>
            </div>            
        </div>        
    </body>
</html>