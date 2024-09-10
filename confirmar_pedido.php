<?php
session_start();

// Verifique se o pedido em confirmação existe
if (!isset($_SESSION['pedido_em_confirmacao'])) {
    echo "Erro: Nenhum pedido para confirmar.";
    exit;
}

// Obtenha os dados do pedido
$pedido = $_SESSION['pedido_em_confirmacao'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Pedido</title>
    <link rel="stylesheet" href="./styles/confirmar_pedido.css">
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

        .finalize-button {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .finalize-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmar Pedido</h1>

        <h2>Detalhes do Cliente:</h2>
        <p><strong>Nome:</strong> <?php echo $pedido['nome']; ?></p>
        <p><strong>CPF:</strong> <?php echo $pedido['cpf']; ?></p>
        <p><strong>Telefone:</strong> <?php echo $pedido['telefone']; ?></p>
        <p><strong>Forma de Entrega:</strong> <?php echo ucfirst($pedido['forma_entrega']); ?></p>

        <h2>Itens do Pedido:</h2>
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
                <?php foreach ($pedido['carrinho'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['produto']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($item['tamanho'])); ?></td>
                        <td><?php echo !empty($item['sabores']) ? htmlspecialchars(implode(', ', $item['sabores'])) : 'Nenhum sabor'; ?></td>
                        <td><?php echo !empty($item['bebidas']) ? htmlspecialchars(implode(', ', $item['bebidas'])) : 'Nenhuma bebida'; ?></td>
                        <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total:</strong> R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>

        <!-- Link para confirmar o pedido -->
        <a href="processar_pedido.php" class="finalize-button">Confirmar e Finalizar Pedido</a>
    </div>
</body>
</html>
