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

// Verifica se a requisição de exclusão foi feita
if (isset($_POST['excluir'])) {
    $funcionario_id = $_POST['funcionario_id'];

    // SQL para excluir o funcionário
    $sql = "DELETE FROM funcionarios WHERE id = $funcionario_id";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "Funcionário excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir funcionário: " . $conn->error;
    }
}

// Buscar todos os funcionários
$sql = "SELECT f.id, f.nome, f.cargo, f.data_admissao, s.nome AS setor
        FROM funcionarios f
        JOIN setores s ON f.setor_id = s.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Funcionários</title>
    <link rel="stylesheet" href="./styles/lista_funcionarios.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Funcionários</h1>

        <!-- Mensagem de Sucesso -->
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem mensagem-resultado">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <!-- Botão para Cadastrar Novo Funcionário -->
        <div class="adicionar">
            <a href="funcionarios.php" class="button-adicionar">Cadastrar Novo Funcionário</a>
        </div>

        <!-- Tabela de Funcionários -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Setor</th>
                    <th>Data de Admissão</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['cargo']); ?></td>
                            <td><?php echo htmlspecialchars($row['setor']); ?></td>
                            <td><?php echo htmlspecialchars($row['data_admissao']); ?></td>
                            <td>
                                <form method="post" action="lista_funcionarios.php" style="display: inline;">
                                    <input type="hidden" name="funcionario_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="excluir" class="button-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum funcionário cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Função para esconder a mensagem após 2 segundos
        document.addEventListener('DOMContentLoaded', (event) => {
            const mensagem = document.querySelector('.mensagem-resultado');
            if (mensagem) {
                setTimeout(() => {
                    mensagem.style.opacity = 0;
                    setTimeout(() => {
                        mensagem.style.display = 'none';
                    }, 1500); // Tempo para a transição de opacidade
                }, 1000); // Tempo antes de esconder (2 segundos)
            }
        });
    </script>
</body>

</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
