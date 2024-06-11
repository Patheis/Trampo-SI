<?php

if(!isset($_SESSION)) {
    session_start();
}

session_destroy();
// TROQUEI A LOCALIDADE DO ANTERIOR PARA O NOVO
header("Location: InOut.php");

?>