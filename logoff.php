<?php
    session_start();
    // recupera o nome do identificador de sessão
    $cookie_name = session_name();
    // elimina todas as informações relacionadas à sessão atual
    session_destroy();

    // encerra o manipulador de sessão
    session_write_close();

    // limpa o cookie identificador de sessão
    setcookie($cookie_name, '', time());
    header('location:index.php');