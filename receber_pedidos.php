<?php
session_start();

// Verifique se o pedido foi finalizado
if (!isset($_SESSION['pedido_finalizado'])) {
    echo "Nenhum pedido foi finalizado.";
    exit;
}

$pedido = $_SESSION['pedido_finalizado'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedido Finalizado</title>
    <link rel="stylesheet" href="./styles/receber_pedido.css">
</head>
<body>
    <h1>Pedido Finalizado</h1>
    
    <h2>Dados do Cliente</h2>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($pedido['nome']); ?></p>
    <p><strong>CPF:</strong> <?php echo htmlspecialchars($pedido['cpf']); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($pedido['telefone']); ?></p>
    <p><strong>Forma de Entrega:</strong> <?php echo htmlspecialchars($pedido['forma_entrega']); ?></p>

    <h2>Itens do Pedido</h2>
    <ul>
        <?php foreach ($pedido['carrinho'] as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['nome']); ?> - 
                Tamanho: <?php echo htmlspecialchars($item['tamanho']); ?> - 
                Sabores: <?php echo htmlspecialchars(implode(', ', $item['sabores'])); ?> - 
                Preço: R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Total: R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></h3>

    <a href="index.php">Voltar à Página Inicial</a>
</body>
</html>
