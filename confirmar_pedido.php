<?php
session_start();

// Verifica se o carrinho e os dados do cliente existem na sessão
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Erro: Nenhum pedido para confirmar.";
    exit;
}

$dados_cliente = [
    'nome' => $_SESSION['nome'] ?? 'Nome não informado',
    'cpf' => $_SESSION['cpf'] ?? 'CPF não informado',
    'telefone' => $_SESSION['telefone'] ?? 'Telefone não informado',
    'forma_entrega' => $_SESSION['forma_entrega'] ?? 'Forma de entrega não informada'
];

$total_pedido = number_format(array_sum(array_column($_SESSION['carrinho'], 'preco')), 2, ',', '.');
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
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($dados_cliente['nome']); ?></p>
        <p><strong>CPF:</strong> <?php echo htmlspecialchars($dados_cliente['cpf']); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($dados_cliente['telefone']); ?></p>
        <p><strong>Forma de Entrega:</strong> <?php echo htmlspecialchars(ucfirst($dados_cliente['forma_entrega'])); ?></p>

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
                <?php foreach ($_SESSION['carrinho'] as $item): ?>
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

        <p><strong>Total:</strong> R$ <?php echo $total_pedido; ?></p>

        <a href="processar_pedido.php" class="finalize-button">Confirmar e Finalizar Pedido</a>
    </div>
</body>
</html>
