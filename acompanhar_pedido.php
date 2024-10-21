<?php
// Verifique se o CPF foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];

    // Conecte-se ao banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "sistemaunipar";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Obtenha o pedido com base no CPF
    $stmt = $conn->prepare("SELECT id, status, total, data_pedido FROM pedidos WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se há pedidos com o CPF informado
    if ($result->num_rows > 0) {
        $pedido = $result->fetch_assoc();
    } else {
        $erro = "Nenhum pedido encontrado para o CPF informado.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acompanhar Pedido</title>
    <link rel="stylesheet" href="styles/acompanhar_pedido.css">
</head>
<body>
    <div class="container">
        <h1>Acompanhar Pedido</h1>

        <form method="POST" action="">
            <label for="cpf">Digite seu CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            <button type="submit">Buscar Pedido</button>
        </form> 

        <?php if (isset($pedido)): ?>
            <h2>Status do Pedido</h2>
            <p><strong>ID do Pedido:</strong> <?php echo $pedido['id']; ?></p>
            <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
            <p><strong>Total:</strong> R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>
            <p><strong>Data do Pedido:</strong> <?php echo $pedido['data_pedido']; ?></p>
        <?php elseif (isset($erro)): ?>
            <p style="color:red;"><?php echo $erro; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
