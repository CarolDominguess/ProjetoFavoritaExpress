<?php
session_start();

// Verifique se há pedidos finalizados
if (!isset($_SESSION['pedidos']) || empty($_SESSION['pedidos'])) {
    echo "Nenhum pedido foi feito até agora.";
    exit;
}

// Verifique se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_pedido'])) {
    // Pegue o índice do pedido a ser excluído
    $indice_excluir = $_POST['indice'];

    // Verifique se o índice existe nos pedidos
    if (isset($_SESSION['pedidos'][$indice_excluir])) {
        // Remova o pedido da lista de pedidos
        unset($_SESSION['pedidos'][$indice_excluir]);

        // Reorganize os índices do array
        $_SESSION['pedidos'] = array_values($_SESSION['pedidos']);
    }
}
$pedidos = $_SESSION['pedidos'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos Recebidos</title>
    <link rel="stylesheet" href="./styles/pedidos_funcionarios.css">
</head>
<body>
    <h1>Pedidos Recebidos</h1>

    <?php foreach ($pedidos as $index => $pedido): ?>
        <div class="pedido">
            <h2>Pedido #<?php echo $index + 1; ?></h2>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($pedido['nome'] ?? 'N/A'); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($pedido['cpf'] ?? 'N/A'); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($pedido['telefone'] ?? 'N/A'); ?></p>
            <p><strong>Forma de Entrega:</strong> <?php echo htmlspecialchars($pedido['forma_entrega'] ?? 'N/A'); ?></p>
            
            <h3>Itens do Pedido:</h3>
            <ul>
                <?php foreach ($pedido['carrinho'] as $item): ?>
                    <li>
                        Tamanho: <?php echo htmlspecialchars($item['tamanho'] ?? 'Tamanho não especificado'); ?><br>
                        Sabores: <?php echo htmlspecialchars(implode(', ', $item['sabores'] ?? ['Sem sabores'])); ?><br>
                        Forma de Entrega:</strong> <?php echo htmlspecialchars($pedido['forma_entrega'] ?? 'N/A'); ?><br>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total:</strong> R$ <?php echo number_format($pedido['total'] ?? 0, 2, ',', '.'); ?></p>

            <!-- Formulário para excluir o pedido -->
            <form method="post" action="pedidos_funcionarios.php" onsubmit="return confirm('Tem certeza que deseja finalizar este pedido?');">
                <input type="hidden" name="indice" value="<?php echo $index; ?>">
                <button type="submit" name="excluir_pedido">Finalizado</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>
