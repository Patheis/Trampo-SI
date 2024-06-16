<?php

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    die("Você precisa <a href=\"login.php\">fazer login<a> para acessar essa página.");
}

?>