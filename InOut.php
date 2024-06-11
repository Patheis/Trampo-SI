<?php
include('conexao.php');

// Registro do Usuario -->


if(isset($_POST['usuario']) || isset($_POST['senha'])) {

    if(strlen($_POST['usuario']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else if(strlen($_POST['senha']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else {

        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE usuario  = '$usuario'";
        $sql_query = $mysqli->query($sql_code) or die("FALHA SQL: " . $mysql->error);
        
        $quantidade = $sql_query->num_rows;
        
        if($quantidade == 1) {
            
            $sql_code= "SELECT senha FROM usuarios WHERE usuario  = '$usuario' LIMIT 1";
            $sql_exec = $mysqli->query($sql_code) or die("FALHA SQL: " . $mysql->error);
            $user = $sql_exec->fetch_assoc();

            if(password_verify($senha, $user['senha']) == 1) {
                
                $usuario = $sql_query->fetch_assoc();

                if(!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $usuario['id'];

                // JOGUEI PARA A TELA DE BEM VINDO
                header("Location: welcome.php");
                
            } else {
                echo '<script>alert("Senha incorreta!")</script>';
            }
            
        } else {
            echo '<script>alert("Usuário inexistente!")</script>';
        }

  

    }

}

// Cadastro do Usuario -->


if(isset($_POST['usuario']) || isset($_POST['senha']) || isset($_POST['repsenha'])) {
    
    function isValidPassword($password) {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d].\S{8,36}$/';
    
        return preg_match($pattern, $password) ? true : false;
    }

    if(strlen($_POST['usuario']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else if(strlen($_POST['senha']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else if(strlen($_POST['repsenha']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else {
        
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
    
        $sql_code = "SELECT * FROM usuarios WHERE usuario  = '$usuario'";
        $sql_query = $mysqli->query($sql_code) or die("FALHA SQL: " . $mysql->error);
    
        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            echo '<script>alert("Já há alguém com esse nome de usuário")</script>';
            
        } else {
            
            if($_POST['senha'] != $_POST['repsenha']) {
                echo '<script>alert("As senhas devem ser iguais")</script>';
            } else {
                $password = $_POST['senha'];
                if(strlen($_POST['senha']) < 10 || isValidPassword($password) == false) {
                    echo '<script>alert("Senha fraca! Deve conter pelo menos 10 dígitos, incluindo letras minúsculas e maiúsculas, números e caracteres especiais")</script>';
                } else {
                    
                    $senha = password_hash($senha, PASSWORD_DEFAULT);
                    
                    $sql_code = "INSERT INTO usuarios (usuario, senha) VALUES ('$usuario', '$senha')";
                    $sql_query = $mysqli->query($sql_code) or die("FALHA SQL: " . $mysql->error);
                    
                    // AQUI NAO MANDA PARA A OUTRA TELA, MANTEM NA MESMA PAG

                    
                    //header("Location: login.php");
                }
            }


        }
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/arq-login/style.css">
    <title>Fatec Mococa - Acessar</title>
    <script defer src="/arq-login/main.js"></script>
</head>
<body>
    <div class="container right-panel-active">
        
        <!-- Cadastrar  class = POST -->

        <div class="container__form container--signup">
            <form action="" method="POST" id="form1">
                <h2 class="form__title">Cadastrar</h2>
                <input type="text" placeholder="Usuario" class="input" name="usuario" id="login">
                <input type="password" placeholder="Senha" class="input" name="senha" id="senha">
                <input type="password" placeholder="Confirmar Senha" class="input" name="repsenha" id="repsenha">
                <button type="submit" class="btn">Cadastrar</button>
            </form>
        </div>
    
        <!-- Login  class = POST-->
        <div class="container__form container--signin">
            <form action="" class="POST" id="form2">
                <h2 class="form__title">Acessar</h2>
                <input type="text" placeholder="Usuario" name="usuario" id="login" />
                <input type="password" placeholder="Senha" name="senha" id="senha" />
                
                <button class="btn">Acessar</button>
            </form>
        </div>
    
        <!-- A tela que passa por cima -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                    <button class="btn" id="signIn">Acessar</button>
                </div>
                <div class="overlay__panel overlay--right">
                    <button class="btn" id="signUp">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
