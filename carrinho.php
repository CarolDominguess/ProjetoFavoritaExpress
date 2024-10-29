<?php
session_start();

if (empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit;
}

// Funções para calcular preços
function calcularPreco($item, $tipo) {
    $precos = [
        'pequena' => 25, 'media' => 35, 'grande' => 55, 'gigante' => 65,
        'coca-cola' => 5, 'fanta' => 5, 'guarana' => 4, 'suco-laranja' => 8,
        'agua-sem-gas' => 3, 'agua-com-gas' => 4
    ];
    return $precos[$item] ?? 0;
}

// Excluir item do carrinho
if (isset($_POST['excluir'])) {
    unset($_SESSION['carrinho'][$_POST['excluir']]);
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="styles/carrinho.css">
</head>
<body>
    <div class="container">
        <h1>Seu Carrinho</h1>
        <table>
            <tr>
                <th>Tamanho</th>
                <th>Sabores</th>
                <th>Quantidade</th>
                <th>Bebida</th>
                <th>Preço</th>
                <th>Ação</th>
            </tr>

            <?php foreach ($_SESSION['carrinho'] as $index => $item): 
                $precoItem = (calcularPreco($item['tamanho'], 'pizza') + calcularPreco($item['bebida'], 'bebida')) * $item['quantidade'];
                $total += $precoItem;
            ?>
                <tr>
                    <td><?= ucfirst($item['tamanho']) ?></td>
                    <td><?= is_array($item['sabores']) ? implode(', ', $item['sabores']) : $item['sabores'] ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td><?= $item['bebida'] ?></td>
                    <td>R$ <?= number_format($precoItem, 2, ',', '.') ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="excluir" value="<?= $index ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Total: R$ <?= number_format($total, 2, ',', '.') ?></h2>

        <a id="continua" href="pedido.php">Continuar Pedindo</a>
        <a id="finaliza" href="finalizar_pedido.php">Finalizar Pedido</a>
    </div>
</body>
</html>
