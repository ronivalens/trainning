<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    
    // Validação básica dos campos (pode ser adaptada de acordo com suas necessidades)
    if (empty($nome) || empty($email) || empty($telefone)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Conexão com o banco de dados (substitua as credenciais de acordo com seu ambiente)
        $servername = "localhost";
        $username = "seu_usuario";
        $password = "sua_senha";
        $database = "seu_banco_de_dados";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Insere os dados no banco de dados
        $sql = "INSERT INTO pessoas (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Pessoa Física</title>
</head>
<body>
    <h1>Cadastro de Pessoa Física</h1>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>
        
        <label for="email">E-mail:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" required><br><br>
        
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
