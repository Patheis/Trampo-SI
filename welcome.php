<?php 
include('protect.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/arq-bem-vindo/style-w.css">

    <title>Obrigado pelo acesso!</title>
</head>
<body>
    <div class="container">
        <!-- Container do formulário de login   class="POST" -->
        <div class="container__form container--signin">

            <form action="" class="POST" id="form">
                <h2 class="form__title">Bem-vindo!</h2>
                <h1>Obrigado por acessar o sistema de login com criptografia</h1>

                <!-- TROQUEI O LINK PARA ONDE VAI DPS DE SAIR -->
                <a href="InOut.php" class="logout-button">
                    
                <button class="btn" id="confirmBtn">Sair</button>

                </a>
            </form>

            

        </div>
        <div class="container__overlay">
            <div class="overlay__panel">
                <h2 class="form__title">Confirmação</h2>
                <p>Seu acesso foi confirmado!</p>
                <div class="bk-gif">
                 
                </div>
            </div>
        </div>
        
    </div>

    
</body>
</html>
