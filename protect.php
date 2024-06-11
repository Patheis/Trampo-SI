<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    // JOGUEI PARA A TELA PRINCIPAL PARA VERIFICACAO
    die("Você precisa <a href=\"InOut.php\">fazer login<a> para acessar essa página.");
}

?>