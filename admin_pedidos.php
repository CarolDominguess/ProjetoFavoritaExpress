<?php
session_start(); // Inicie a sessão

// Conecte-se ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "sistemaunipar";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifique se o status foi alterado e atualizado no banco de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pedido_id']) && isset($_POST['status'])) {
        $pedido_id = $_POST['pedido_id'];
        $novo_status = $_POST['status'];

        // Atualize o status do pedido no banco de dados
        $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $novo_status, $pedido_id);
        $stmt->execute();
        $stmt->close();
    }

    // Verifique se a solicitação é para remover um pedido da lista
    if (isset($_POST['remove_id'])) {
        $remove_id = $_POST['remove_id'];
        
        // Adiciona o pedido à sessão de removidos
        if (!isset($_SESSION['removed_orders'])) {
            $_SESSION['removed_orders'] = [];
        }
        $_SESSION['removed_orders'][] = $remove_id;
    }
}

// Obter todos os pedidos
$sql = "SELECT * FROM pedidos ORDER BY id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Administração de Pedidos</title>
    <link rel="stylesheet" href="styles/admin_pedidos.css">
    <script>
        function removeRow(button, pedidoId) {
            if (confirm("Tem certeza que deseja remover este pedido da lista?")) {
                // Cria um formulário temporário para enviar a solicitação de remoção
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "remove_id";
                input.value = pedidoId;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Pedidos Recebidos</h1>
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
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Verifica se o pedido foi removido da lista
                        if (isset($_SESSION['removed_orders']) && in_array($row['id'], $_SESSION['removed_orders'])) {
                            continue; // Pula a iteração se o pedido estiver na lista removida
                        }
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>{$row['cpf']}</td>";
                        echo "<td>{$row['telefone']}</td>";
                        echo "<td>{$row['forma_entrega']}</td>";
                        echo "<td>{$row['endereco']}</td>";
                        echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
                        echo "<td>{$row['data_pedido']}</td>";
                        echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='pedido_id' value='{$row['id']}'>
                                    <select name='status' onchange='this.form.submit()'>
                                        <option value='Recebido' " . ($row['status'] == 'Recebido' ? 'selected' : '') . ">Recebido</option>
                                        <option value='Preparando' " . ($row['status'] == 'Preparando' ? 'selected' : '') . ">Preparando</option>
                                        <option value='Enviado' " . ($row['status'] == 'Enviado' ? 'selected' : '') . ">Enviado</option>
                                        <option value='Entregue' " . ($row['status'] == 'Entregue' ? 'selected' : '') . ">Entregue</option>
                                    </select>
                                </form>
                              </td>";
                        echo "<td><a href='ver_pedido.php?id={$row['id']}'>Ver detalhes</a> | <button class='remove-btn' onclick='removeRow(this, {$row['id']})'>Remover da Lista</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Nenhum pedido encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a id="voltar" href="admin_pizzaria.php">Voltar para Painel</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
