<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Carrinho</title>
    <link rel="stylesheet" href="./styles/visualizar_carrinho.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .back-button, .finalize-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        .back-button:hover, .finalize-button:hover {
            text-decoration: underline;
        }

        .finalize-button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
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

            <a href="finalizar_pedido.php" class="finalize-button">Finalizar Pedido</a>
        <?php else: ?>
            <p>Seu carrinho está vazio.</p>
        <?php endif; ?>

        <a href="carrinho.php" class="back-button">Voltar ao Pedido</a>
    </div>
</body>
</html>
