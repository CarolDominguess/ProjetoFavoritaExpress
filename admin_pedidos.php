<?php
session_start();

// Conecte-se ao banco de dados
$servername = "localhost"; // Normalmente 'localhost'
$username = "root"; // Seu usuário do MySQL
$password = ""; // Sua senha do MySQL
$database = "sistemaunipar"; // O nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o pedido deve ser removido
if (isset($_GET['remover_id'])) {
    $remover_id = intval($_GET['remover_id']);
    
    // Atualizar o status do pedido para 'removido'
    $sql_remover = "UPDATE pedidos SET status = 'removido' WHERE id = ?";
    $stmt = $conn->prepare($sql_remover);
    $stmt->bind_param("i", $remover_id);
    
    if ($stmt->execute()) {
        echo "Pedido removido da lista com sucesso!";
    } else {
        echo "Erro ao remover o pedido.";
    }
    $stmt->close();
}

// Consultar pedidos que estão com status 'ativo'
$sql = "SELECT pedidos.id, pedidos.nome, pedidos.cpf, pedidos.telefone, pedidos.forma_entrega, pedidos.endereco, pedidos.total, pedidos.data 
        FROM pedidos 
        WHERE pedidos.status = 'ativo'
        ORDER BY pedidos.data DESC";

$result = $conn->query($sql);

if ($result === false) {
    // Se a consulta falhar, mostre o erro
    echo "Erro na consulta SQL: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Administração de Pedidos</title>
    <link rel="stylesheet" href="styles/admin_pedidos.css">
</head>
<body>
    <div class="container">
        <h1>Pedidos da Pizzaria</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Forma de Entrega</th>
                    <th>Endereço</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Detalhes</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verificar se há resultados antes de tentar acessar num_rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nome'] . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . ($row['forma_entrega'] == 'entrega' ? 'Entrega' : 'Retirada') . "</td>";
                        echo "<td>" . ($row['forma_entrega'] == 'entrega' ? $row['endereco'] : '-') . "</td>";
                        echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
                        echo "<td>" . date('d/m/Y H:i', strtotime($row['data'])) . "</td>";
                        echo "<td><a href='detalhes_pedido.php?id=" . $row['id'] . "'>Ver Detalhes</a></td>";
                        echo "<td><a href='admin_pedidos.php?remover_id=" . $row['id'] . "'>Remover da lista</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum pedido encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
