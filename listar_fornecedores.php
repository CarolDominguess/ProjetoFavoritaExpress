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
    $fornecedor_id = $_POST['fornecedor_id'];

    // SQL para excluir o fornecedor
    $sql = "DELETE FROM fornecedores WHERE id = $fornecedor_id";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "Fornecedor excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir fornecedor: " . $conn->error;
    }
}

// Buscar todos os fornecedores
$sql = "SELECT * FROM fornecedores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Fornecedores</title>
    <link rel="stylesheet" href="./styles/listar_fornecedores.css">
</head>
<body>

    <div class="container">
        <h1>Lista de Fornecedores</h1>
        
        <!-- Link para cadastrar novos fornecedores -->
        <a href="cadastrar_fornecedor.php" class="button-adicionar">Cadastrar Novo Fornecedor</a>

        <!-- Modal de notificação -->
        <div class="modal" id="mensagemModal">
            <span id="mensagemTexto"></span>
            <button class="close-btn" onclick="fecharModal()">X</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CNPJ</th>
                    <th>Nome</th>
                    <th>Produto</th>
                    <th>Valores</th>
                    <th>Data de Cadastro</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['cnpj']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['produto']); ?></td>
                            <td>R$ <?php echo number_format($row['valores'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['data_cadastro']); ?></td>
                            <td>
                                <form method="post" action="listar_fornecedores.php">
                                    <input type="hidden" name="fornecedor_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="excluir" class="button-excluir">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhum fornecedor cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Função para exibir o modal com a mensagem
        function exibirMensagem(mensagem, erro = false) {
            const modal = document.getElementById('mensagemModal');
            const mensagemTexto = document.getElementById('mensagemTexto');
            mensagemTexto.innerText = mensagem;

            if (erro) {
                modal.classList.add('error');
            } else {
                modal.classList.remove('error');
            }

            modal.style.display = 'block';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 3000);
        }

        // Função para fechar manualmente o modal
        function fecharModal() {
            document.getElementById('mensagemModal').style.display = 'none';
        }

        // Exibe a mensagem se existir
        <?php if (!empty($mensagem)): ?>
            exibirMensagem("<?php echo addslashes($mensagem); ?>", <?php echo isset($conn->error) ? 'true' : 'false'; ?>);
        <?php endif; ?>
    </script>

</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
