<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Carrinho</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="./styles/vizualizarcarrinho.css">
</head>
<body>
    <h1>Visualizar Carrinho</h1>

    <?php if (!empty($_SESSION['carrinho'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Tamanho</th>
                    <th>Sabor</th>
                    <th>Bebida</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $index => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['produto']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($item['tamanho'])); ?></td>
                        <td><?php echo !empty($item['sabores']) ? htmlspecialchars(implode(', ', $item['sabores'])) : 'Nenhum sabor'; ?></td>
                        <td>
                            <?php echo !empty($item['bebidas']) ? htmlspecialchars(implode(', ', $item['bebidas'])) : 'Nenhuma bebida'; ?>
                        </td>
                        <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <form action="remover_do_carrinho.php" method="post">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total: R$ <?php echo number_format(array_sum(array_column($_SESSION['carrinho'], 'preco')), 2, ',', '.'); ?></p>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <a href="carrinho.php">Voltar ao Pedido</a>
</body>
</html>
