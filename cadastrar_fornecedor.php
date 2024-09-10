<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "localhost";
$username = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = "sistemaunipar"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $cnpj = $_POST['cnpj'];
    $nome = $_POST['nome'];
    $produto = $_POST['produto'];
    $valores = $_POST['valores'];
    $data_cadastro = $_POST['data'];

    // Inserir os dados no banco
    $sql = "INSERT INTO fornecedores (cnpj, nome, produto, valores, data_cadastro) 
            VALUES ('$cnpj', '$nome', '$produto', '$valores', '$data_cadastro')";

    if ($conn->query($sql) === TRUE) {
        echo "Fornecedor cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    // Fechar a conexão
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2d3e50;
            font-size: 2.2em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cadastrar Fornecedor</h1>

        <form action="cadastrar_fornecedor.php" method="post">
            <label for="cnpj">CNPJ:</label>
            <input type="text" id="cnpj" name="cnpj" required>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="produto">Produto:</label>
            <input type="text" id="produto" name="produto" required>

            <label for="valores">Valores:</label>
            <input type="number" id="valores" name="valores" step="0.01" required>

            <label for="data">Data de Cadastro:</label>
            <input type="date" id="data" name="data" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

</body>
</html>
