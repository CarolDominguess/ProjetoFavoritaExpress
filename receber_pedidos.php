<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Receber Pedidos</title>
    <link rel="stylesheet" href="./styles/receber_pedidos.css">
</head>
<body>
    <h1>Pedidos Recebidos</h1>

    <?php if (isset($_SESSION['pedido_finalizado'])): ?>
        <div class="pedido">
            <h2>Detalhes do Pedido</h2>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($_SESSION['pedido_finalizado']['nome']); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($_SESSION['pedido_finalizado']['cpf']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($_SESSION['pedido_finalizado']['telefone']); ?></p>
            <p><strong>Forma de Entrega:</strong> <?php echo htmlspecialchars($_SESSION['pedido_finalizado']['forma_entrega']); ?></p>

            <h3>Itens do Pedido</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Tamanho</th>
                        <th>Sabor</th>
                        <th>Bebida</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['pedido_finalizado']['carrinho'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['produto']); ?></td>
                            <td><?php echo htmlspecialchars(ucfirst($item['tamanho'])); ?></td>
                            <td><?php echo !empty($item['sabores']) ? htmlspecialchars(implode(', ', $item['sabores'])) : 'Nenhum sabor'; ?></td>
                            <td><?php echo !empty($item['bebidas']) ? htmlspecialchars(implode(', ', $item['bebidas'])) : 'Nenhuma bebida'; ?></td>
                            <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                            <td>R$ <?php echo number_format((float)$item['preco'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p><strong>Total:</strong> R$ <?php echo number_format((float)$_SESSION['pedido_finalizado']['total'], 2, ',', '.'); ?></p>
        </div>

        <?php unset($_SESSION['pedido_finalizado']); // Limpa o pedido após exibição ?>
    <?php else: ?>
        <p>Não há pedidos para exibir.</p>
    <?php endif; ?>

    <a href="index.php">Voltar para a Página Principal</a>
</body>
</html>
