<?php
session_start();

// Conecte-se ao banco de dados
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "sistemaunipar"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID do pedido foi passado via GET
if (isset($_GET['id'])) {
    $pedido_id = $_GET['id'];
    
    // Consultar os detalhes do pedido
    $sql = "SELECT * FROM pedidos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();
    
    if ($pedido) {
        // Consultar os itens do pedido
        $sql_itens = "SELECT * FROM itens_pedido WHERE pedido_id = ?";
        $stmt_itens = $conn->prepare($sql_itens);
        $stmt_itens->bind_param("i", $pedido_id);
        $stmt_itens->execute();
        $result_itens = $stmt_itens->get_result();
    } else {
        echo "Pedido não encontrado.";
        exit;
    }
} else {
    echo "ID do pedido não informado.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" href="styles/detalhes_pedido.css">
</head>
<body>
    <div class="container">
        <h1>Detalhes do Pedido #<?php echo $pedido['id']; ?></h1>
        <p><strong>Nome:</strong> <?php echo $pedido['nome']; ?></p>
        <p><strong>CPF:</strong> <?php echo $pedido['cpf']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $pedido['telefone']; ?></p>
        <p><strong>Forma de Entrega:</strong> <?php echo ($pedido['forma_entrega'] == 'entrega' ? 'Entrega' : 'Retirada'); ?></p>
        <p><strong>Endereço:</strong> <?php echo ($pedido['forma_entrega'] == 'entrega' ? $pedido['endereco'] : 'N/A'); ?></p>
        <p><strong>Total:</strong> R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>
        <p><strong>Data do Pedido:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></p>

        <h2>Itens do Pedido</h2>
        <table>
            <thead>
                <tr>
                    <th>Tamanho</th>
                    <th>Sabores</th>
                    <th>Quantidade</th>
                    <th>Bebida</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_itens->num_rows > 0) {
                    while ($item = $result_itens->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $item['tamanho'] . "</td>";
                        echo "<td>" . $item['sabores'] . "</td>";
                        echo "<td>" . $item['quantidade'] . "</td>";
                        echo "<td>" . $item['bebida'] . "</td>";
                        echo "<td>R$ " . number_format($item['preco'], 2, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum item encontrado.</td></tr>";
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
