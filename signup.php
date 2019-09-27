<?php
    include("header.php");
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="window">
            <div  class="menu-s">
                <div class="bar-side bar-s">
                    <a class="opc-start" href="index.php">Inicio</a>
                    <a class="opc-start opc-selec" href="signup.php">Cadastre-se</a>
                </div>
            </div>
            <div class="content">
                <div class="cont">
                    <div class="cont1">
                        <h2>Criar uma nova conta</h2>
                        <form id="cadastrar" method="POST" action="register.php">
                            <table cellspacing="0">
                                <tr>
                                    <td>
                                        <input class="inputtext" type="text" name="nome" value="" placeholder="Nome" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="cargo" class="select-cad">
                                            <option value="" >Selecione Cargo</option>
                                            <option value="alu">Aluno</option>
                                            <option value="pro" >Professor</option>
                                            <option value="adm" >Administrador</option>
                                        </select>
                                        <input class="inputtext input-select" type="text" name="cod" value="" placeholder="Código" autocomplete="off" style="display: none">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="inputtext" type="email" name="email" value="" placeholder="E-mail" autocomplete="off">
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        <input class="inputtext" type="password" name="senha" value="" placeholder="Nova senha" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="inputtext" type="password" placeholder="Repetir senha" autocomplete="off">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <button class="entra" type="submit">Cadastrar</button>
                                        <a href="index.php" class="entra cancel">Cancelar</a>
                                        <button class="entra cancel" type="reset">Limpar</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>