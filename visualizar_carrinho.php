<?php
session_start();

// Remove o item do carrinho
if (isset($_POST['index'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['carrinho'][$index])) {
        unset($_SESSION['carrinho'][$index]);
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexa o array
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Carrinho</title>
    <link rel="stylesheet" href="./styles/vizualizarcarrinho.css">
</head>
<body>
    <h1>Visualizar Carrinho</h1>

    <?php if (!empty($_SESSION['carrinho'])): ?>
        <form action="visualizar_carrinho.php" method="post">
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
                            <td>
                                <?php
                                if (isset($item['sabores']) && is_array($item['sabores'])) {
                                    echo !empty($item['sabores']) ? implode(', ', array_map('htmlspecialchars', $item['sabores'])) : 'Nenhum sabor';
                                } else {
                                    echo 'Nenhum sabor';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if (isset($item['tem_bebida']) && $item['tem_bebida']) {
                                    if (isset($item['bebidas']) && is_array($item['bebidas'])) {
                                        echo !empty($item['bebidas']) ? implode(', ', array_map('htmlspecialchars', $item['bebidas'])) : 'Nenhuma bebida selecionada';
                                    } else {
                                        echo 'Nenhuma bebida selecionada';
                                    }
                                } else {
                                    echo 'Nenhuma bebida';
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td>
                                <form action="visualizar_carrinho.php" method="post" style="display: inline;">
                                    <input type="hidden" name="index" value="<?php echo htmlspecialchars($index); ?>">
                                    <button type="submit">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>Total: R$ <?php echo number_format(array_sum(array_column($_SESSION['carrinho'], 'preco')), 2, ',', '.'); ?></p>
        </form>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>

    <a href="carrinho.php">Voltar ao Pedido</a>
</body>
</html>
