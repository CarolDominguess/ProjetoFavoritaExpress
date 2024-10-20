<?php
session_start();

// Verifique se o carrinho está definido
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit;
}

// Função para calcular o preço com base no tamanho da pizza
function calcularPrecoPizza($tamanho) {
    switch ($tamanho) {
        case 'pequena':
            return 25.00;
        case 'media':
            return 35.00;
        case 'grande':
            return 55.00;
        case 'gigante':
            return 65.00;
        default:
            return 0;
    }
}

// Função para calcular o preço da bebida
function calcularPrecoBebida($bebida) {
    switch ($bebida) {
        case 'coca-cola':
            return 7.00;
        case 'fanta':
            return 5.00;
        case 'guarana':
            return 5.00;
        case 'suco-laranja':
            return 9.00;
        default:
            return 0;
    }
}

// Função para excluir item do carrinho
if (isset($_POST['excluir'])) {
    $indiceExcluir = $_POST['excluir'];
    unset($_SESSION['carrinho'][$indiceExcluir]);
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']); // Reindexa o array
}

// Calcular o total
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
        <h1>Seu Carrinh</h1>
        <table>
            <tr>
                <th>Tamanho</th>
                <th>Sabores</th>
                <th>Quantidade</th>
                <th>Bebida</th>
                <th>Preço</th>
                <th>Ação</th>
            </tr>

            <?php foreach ($_SESSION['carrinho'] as $index => $item): ?>
                <?php
                    $precoPizza = calcularPrecoPizza($item['tamanho']);
                    $precoBebida = calcularPrecoBebida($item['bebida']);
                    $precoItem = ($precoPizza + $precoBebida) * $item['quantidade'];
                    $total += $precoItem;
                ?>
                <tr>
                    <td><?php echo ucfirst($item['tamanho']); ?></td>
                    <td>
                        <?php 
                        // Verificar se "sabores" é um array
                        if (is_array($item['sabores'])) {
                            echo implode(', ', $item['sabores']);
                        } else {
                            echo $item['sabores']; // Exibe o sabor diretamente se não for array
                        }
                        ?>
                    </td>
                    <td><?php echo $item['quantidade']; ?></td>
                    <td><?php echo $item['bebida']; ?></td>
                    <td>R$ <?php echo number_format($precoItem, 2, ',', '.'); ?></td>
                    <td>
                        <form action="carrinho.php" method="POST">
                            <input type="hidden" name="excluir" value="<?php echo $index; ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>

        <a href="pedido.php">Continuar Pedindo</a>
        <a href="finalizar_pedido.php">Finalizar Pedido</a>
    </div>
</body>
</html>
