<?php
// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecta-se ao banco de dados (substitua as credenciais conforme necessário)
    $servername = "localhost";
    $username = "jpatheis";
    $password = "patheis842";
    $database = "sistema_login";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Valida os dados do formulário
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "Por favor, preencha todos os campos.";
    } elseif ($password !== $confirmPassword) {
        echo "As senhas não coincidem.";
    } else {
        // Verifica se o nome de usuário ou email já estão em uso
        $checkQuery = "SELECT * FROM usuarios WHERE username='$username' OR email='$email'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            echo "Nome de usuário ou email já estão em uso.";
        } else {
            // Hash da senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insere os dados do usuário no banco de dados
            $insertQuery = "INSERT INTO usuarios (username, email, senha) VALUES ('$username', '$email', '$hashedPassword')";

            if ($conn->query($insertQuery) === TRUE) {
                echo "Usuário registrado com sucesso!";
            } else {
                echo "Erro ao registrar usuário: " . $conn->error;
            }
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
