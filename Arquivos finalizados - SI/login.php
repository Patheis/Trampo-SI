<?php
include('conexao.php');

if (isset($_POST['usuario']) || isset($_POST['senha'])) {
    if (strlen($_POST['usuario']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else if (strlen($_POST['senha']) == 0) {
        echo '<script>alert("Preencha todos os campos")</script>';
    } else {
        // Obtendo os dados do formulário
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Preparando a consulta SQL para evitar SQL Injection
        $stmt = $mysqli->prepare("SELECT senha FROM usuarios WHERE usuario = ?");
        $stmt->bind_param('s', $usuario);  // Associando o parâmetro 'usuario'

        $stmt->execute();  // Executando a consulta

        $result = $stmt->get_result();  // Obtendo o resultado


        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verificando a senha
            if (password_verify($senha, $user['senha'])) {
                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $user['id'];  // Iniciando a sessão
                header("Location: home.php"); // lanca para o html
                exit();  // Encerrando o script após redirecionamento
            } else {
                echo '<script>alert("Senha incorreta!")</script>';
            }
        } else {
            echo '<script>alert("Usuário inexistente!")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Seguranca</title>
    
</head>
<body>

<div class="container right-panel-active">
    <!-- Sign Up - OK -->
    <div class="container__form container--signup">
        <form method="POST" action="" class="form" id="form1">    
            <h2 class="form__title">Acessar</h2>
            <input type="text" placeholder="Usuario" class="input" name="usuario" id="login" >
            <input type="password" placeholder="Senha" class="input" name="senha" id="senha" >
            <div class="button-container"> 
			<button type="submit" class="btn" value="">Acessar</button>  
			  
            </div>    
            <div>
                Ainda não tem conta? <a href="signup.php">Inscreva-se!</a>
            </div>
        </form>
    </div> 

    <!-- Sign In -->
    <div class="container__form container--signin">
        <form action="#" class="form" id="form2">
            <h2 class="form__title2">Trabalho de Seguranca da Informacao</h2>
            <div>
                  <img src="fatec-removebg-preview (1).png" alt="">
            </div>
			<h2 class="form__title">Fatec Mococa - ADS</h2>	
        </form>
    </div>

    <!-- Overlay -->
    <div class="container__overlay">
        <div class="overlay">
            <div class="overlay__panel overlay--left">
                <button class="btn" id="signIn">Sobre o site</button>
            </div>
            <div class="overlay__panel overlay--right">
                <button class="btn" id="signUp">Acessar</button>
            </div>
        </div>
    </div>
</div>   

<script>
const signInBtn = document.getElementById("signIn");
const signUpBtn = document.getElementById("signUp");
const container = document.querySelector(".container");

signInBtn.addEventListener("click", () => {
    container.classList.remove("right-panel-active");
});

signUpBtn.addEventListener("click", () => {
    container.classList.add("right-panel-active");
});
</script>
<style>
 
        /*
         DAQUI PRA CIMA É DELES 
        */

:root {
	/* COLORS */
	--white: #e9e9e9;
	--gray: #333;
	--blue: #0367a6;
	--lightblue: #008997;

	/* RADII */
	--button-radius: 0.7rem;

	/* SIZES */
	--max-width: 758px;
	--max-height: 420px;

	font-size: 16px;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
		Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
}



body {
	align-items: center;
	background-color: var(--white);
	background: url("img.jpg");
	background-attachment: fixed;
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	display: grid;
	height: 100vh;
	place-items: center;
    overflow: hidden;
}

.form__title {
	font-weight: 300;
	margin: 0;
	margin-bottom: 1.25rem;
}

.form__title2 {
	font-weight: 450;
	margin: 0;
	margin-bottom: 1.25rem;
	
}

.link {
	color: var(--gray);
	font-size: 0.9rem;
	margin: 1.5rem 0;
	text-decoration: none;
}

.container {
	background-color: var(--white);
	border-radius: var(--button-radius);
	box-shadow: 0 0.9rem 1.7rem rgba(0, 0, 0, 0.25),
		0 0.7rem 0.7rem rgba(0, 0, 0, 0.22);
	height: var(--max-height);
	max-width: var(--max-width);
	overflow: hidden;
	position: relative;
	width: 100%;
}

.container__form {
	height: 100%;
	position: absolute;
	top: 0;
	transition: all 0.6s ease-in-out;
}

.container--signin {
	left: 0;
	width: 50%;
	z-index: 2;
}

.container.right-panel-active .container--signin {
	transform: translateX(100%);
}

.container--signup {
	left: 0;
	opacity: 0;
	width: 50%;
	z-index: 1;
}

.container.right-panel-active .container--signup {
	animation: show 0.6s;
	opacity: 1;
	transform: translateX(100%);
	z-index: 5;
}

.container__overlay {
	height: 100%;
	left: 50%;
	overflow: hidden;
	position: absolute;
	top: 0;
	transition: transform 0.6s ease-in-out;
	width: 50%;
	z-index: 100;
}

.container.right-panel-active .container__overlay {
	transform: translateX(-100%);
}

.overlay {
	background-color: var(--lightblue);
	background: url("img.jpg");
	background-attachment: fixed;
	background-position: center;
	background-repeat: no-repeat;
	background-size: cover;
	height: 100%;
	left: -100%;
	position: relative;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
	width: 200%;
}

.container.right-panel-active .overlay {
	transform: translateX(50%);
}

.overlay__panel {
	align-items: center;
	display: flex;
	flex-direction: column;
	height: 100%;
	justify-content: center;
	position: absolute;
	text-align: center;
	top: 0;
	transform: translateX(0);
	transition: transform 0.6s ease-in-out;
	width: 50%;
}

.overlay--left {
	transform: translateX(-20%);
}

.container.right-panel-active .overlay--left {
	transform: translateX(0);
}

.overlay--right {
	right: 0;
	transform: translateX(0);
}

.container.right-panel-active .overlay--right {
	transform: translateX(20%);
}

.btn {
	background-color: var(--blue);
	background-image: linear-gradient(90deg, var(--blue) 0%, var(--lightblue) 74%);
	border-radius: 20px;
	border: 1px solid var(--blue);
	color: var(--white);
	cursor: pointer;
	font-size: 0.8rem;
	font-weight: bold;
	letter-spacing: 0.1rem;
	padding: 0.9rem 4rem;
	text-transform: uppercase;
	transition: transform 80ms ease-in;
}

.form > .btn {
	margin-top: 1.5rem;
}

.btn:active {
	transform: scale(0.95);
}

.btn:focus {
	outline: none;
}

.form {
	background-color: var(--white);
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 3rem;
	height: 100%;
	text-align: center;
}

.input {
	background-color: #fff;
	border: none;
	padding: 0.9rem 0.9rem;
	margin: 0.5rem 0;
	width: 100%;
}

@keyframes show {
	0%,
	49.99% {
		opacity: 0;
		z-index: 1;
	}

	50%,
	100% {
		opacity: 1;
		z-index: 5;
	}
}

.bk-gif{
  
  background-position: center;
  background-size: 150px;
  width: 260px;
  height: 250px;
}  
</style>


</body>
</html>