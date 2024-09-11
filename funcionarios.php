<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Conectar ao banco de dados
$servername = "localhost";
$username = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco de dados
$dbname = "sistemaunipar"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Variável para armazenar a mensagem de sucesso ou erro
$mensagem = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_funcionario = $_POST['nome_funcionario'];
    $cargo = $_POST['cargo'];
    $setor_id = $_POST['setor'];
    $data_admissao = $_POST['data_admissao']; // Atualizado para data de admissão

    // SQL para inserir funcionário
    $sql = "INSERT INTO funcionarios (nome, cargo, setor_id, data_admissao) 
            VALUES ('$nome_funcionario', '$cargo', '$setor_id', '$data_admissao')";

    if ($conn->query($sql) === TRUE) {
        // Redireciona para a página de listagem de funcionários por setor
        header("Location: lista_funcionarios.php");
        exit(); // Certifica-se de que o script será interrompido após o redirecionamento
    } else {
        $mensagem = "Erro ao adicionar funcionário: " . $conn->error;
    }
}

// Buscar todos os setores
$sql_setores = "SELECT * FROM setores";
$result_setores = $conn->query($sql_setores);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="./styles/funcionarios.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Funcionário</h1>

        <!-- Mensagem de Sucesso -->
        <div class="mensagem">
            <?php if (!empty($mensagem)) echo htmlspecialchars($mensagem); ?>
        </div>

        <!-- Formulário de Adicionar Funcionário -->
        <div class="form-container">
            <form method="POST" action="funcionarios.php">
                <label for="nome_funcionario">Nome do Funcionário:</label>
                <input type="text" name="nome_funcionario" required>

                <label for="cargo">Cargo:</label>
                <input type="text" name="cargo" required>

                <label for="setor">Setor:</label>
                <select name="setor" required>
                    <option value="">Selecione o Setor</option>
                    <?php while ($row = $result_setores->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($row['id']); ?>">
                            <?php echo htmlspecialchars($row['nome']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="data_admissao">Data de Admissão:</label>
                <input type="date" name="data_admissao" required>

                <button type="submit">Adicionar Funcionário</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
