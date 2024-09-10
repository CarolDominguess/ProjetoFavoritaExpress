<?php
session_start();

// Verifica se a ação de remover o pedido foi solicitada
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remover_pedido'])) {
    $indice = intval($_POST['indice']);
    
    // Verifica se o índice é válido e existe na sessão
    if (isset($_SESSION['pedidos'][$indice])) {
        unset($_SESSION['pedidos'][$indice]); // Remove o pedido da sessão
        $_SESSION['pedidos'] = array_values($_SESSION['pedidos']); // Reorganiza o array
    }
    
    // Redireciona para evitar o reenvio do formulário ao atualizar a página
    header('Location: pedidos_pizzaria.php');
    exit;
}

// Verifica se a sessão de pedidos existe
$pedidos = isset($_SESSION['pedidos']) ? $_SESSION['pedidos'] : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pedidos da Pizzaria</title>
    <link rel="stylesheet" href="./styles/pedidos_pizzaria.css">
</head>
<body>
    <div class="container">
        <h1>Pedidos da Pizzaria</h1>

        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $index => $pedido): ?>
                <div class="pedido-item">
                    <h2>Pedido #<?php echo $index + 1; ?></h2>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($pedido['nome']); ?></p>
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($pedido['cpf']); ?></p>
                    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($pedido['telefone']); ?></p>
                    <p><strong>Forma de Entrega:</strong> <?php echo htmlspecialchars($pedido['forma_entrega']); ?></p>

                    <h3>Itens do Pedido:</h3>
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
                                    <td><?php echo htmlspecialchars(implode(', ', $item['sabores'])); ?></td>
                                    <td><?php echo htmlspecialchars(implode(', ', $item['bebidas'])); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                                    <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <p><strong>Total do Pedido:</strong> R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>

                    <!-- Botão de Concluído -->
                    <form method="post" action="pedidos_pizzaria.php">
                        <input type="hidden" name="indice" value="<?php echo $index; ?>">
                        <button type="submit" name="remover_pedido" class="button-concluido">Concluído</button>
                    </form>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Não há pedidos no momento.</p>
        <?php endif; ?>
    </div>
</body>
</html>