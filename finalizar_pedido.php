<?php
session_start();

// Verifique se o carrinho está definido
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit;
}

// Conecte-se ao banco de dados
$servername = "localhost"; // Normalmente 'localhost'
$username = "root"; // Seu usuário do MySQL
$password = ""; // Sua senha do MySQL
$database = "sistemaunipar"; // O nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Funções para calcular o preço das pizzas e bebidas
function calcularPrecoPizza($tamanho) {
    $precos = [
        'pequena' => 25.00,
        'media' => 35.00,
        'grande' => 55.00,
        'gigante' => 65.00
    ];

    return isset($precos[$tamanho]) ? $precos[$tamanho] : 0;
}

function calcularPrecoBebida($bebida) {
    $precos = [
        'coca-cola' => 7.00,
        'fanta' => 5.00,
        'guarana' => 5.00,
        'suco-laranja' => 9.00
    ];

    return isset($precos[$bebida]) ? $precos[$bebida] : 0;
}

// Calcular o preço total do pedido
$total = 0;
foreach ($_SESSION['carrinho'] as $item) {
    $precoPizza = calcularPrecoPizza($item['tamanho']);
    $precoBebida = calcularPrecoBebida($item['bebida']);
    $precoItem = ($precoPizza + $precoBebida) * $item['quantidade'];
    $total += $precoItem;
}

// Adicionar taxa de entrega se for entrega
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $forma_entrega = $_POST['forma_entrega'];
    $endereco = $forma_entrega == 'entrega' ? $_POST['endereco'] : '';

    // Adiciona taxa de entrega se for entrega
    if ($forma_entrega == 'entrega') {
        $total += 7.00;
    }

    // Salvar pedido no banco de dados
    $stmt = $conn->prepare("INSERT INTO pedidos (nome, cpf, telefone, forma_entrega, endereco, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $nome, $cpf, $telefone, $forma_entrega, $endereco, $total);
    $stmt->execute();
    $pedido_id = $stmt->insert_id; // ID do pedido inserido

    // Agora, vamos salvar os itens do pedido na tabela itens_pedido
    foreach ($_SESSION['carrinho'] as $item) {
        $precoPizza = calcularPrecoPizza($item['tamanho']);
        $precoBebida = calcularPrecoBebida($item['bebida']);
        $precoItem = ($precoPizza + $precoBebida) * $item['quantidade'];

        $sabores = implode(", ", $item['sabores']); // Transformar os sabores em uma string

        $stmt = $conn->prepare("INSERT INTO itens_pedido (pedido_id, tamanho, sabores, quantidade, bebida, preco) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdss", $pedido_id, $item['tamanho'], $sabores, $item['quantidade'], $item['bebida'], $precoItem);
        $stmt->execute();
    }

    // Limpar o carrinho após o pedido ser finalizado
    unset($_SESSION['carrinho']);

    // Fechar a conexão com o banco de dados
    $stmt->close();
    $conn->close();

    // Redirecionar para a página de sucesso
    header("Location: pedido_sucesso.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="styles/finalizar_pedido.css">
    <script>
        function toggleEndereco() {
            var formaEntrega = document.querySelector('input[name="forma_entrega"]:checked').value;
            var enderecoContainer = document.getElementById('endereco_container');
            var totalContainer = document.getElementById('total_container');
            if (formaEntrega === 'entrega') {
                enderecoContainer.style.display = 'block';
                totalContainer.innerHTML = "Total: R$ <?php echo number_format($total + 7.00, 2, ',', '.'); ?>";
            } else {
                enderecoContainer.style.display = 'none';
                totalContainer.innerHTML = "Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Finalizar Pedido</h1>

        <form action="finalizar_pedido.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label>Forma de Entrega:</label>
            <input type="radio" id="entrega" name="forma_entrega" value="entrega" onclick="toggleEndereco()" required>
            <label for="entrega">Entrega</label>
            <input type="radio" id="retirada" name="forma_entrega" value="retirada" onclick="toggleEndereco()" required>
            <label for="retirada">Retirada</label>

            <div id="endereco_container" style="display: none;">
                <label for="endereco">Endereço de Entrega:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, Número, Bairro" required>
            </div>

            <h2 id="total_container">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>

            <button type="submit">Finalizar Pedido</button>
        </form>
    </div>
</body>
</html>
