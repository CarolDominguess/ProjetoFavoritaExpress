<?php
session_start();

// Verifique se o carrinho está definido
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Seu carrinho está vazio.";
    exit;
}

// Conecte-se ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "sistemaunipar";

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
    $forma_entrega = $_POST['forma_entrega'];
    $endereco = ($forma_entrega == 'entrega') ? $_POST['endereco'] : '';

    if ($forma_entrega == 'entrega' && empty($endereco)) {
        die("Erro: Endereço de entrega não fornecido.");
    }

    if ($forma_entrega == 'entrega') {
        $total += 7.00; // Adiciona a taxa de entrega
    }

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];

    // Insere os dados diretamente na tabela pedidos
    foreach ($_SESSION['carrinho'] as $item) {
        $precoPizza = calcularPrecoPizza($item['tamanho']);
        $precoBebida = calcularPrecoBebida($item['bebida']);
        $precoItem = ($precoPizza + $precoBebida) * $item['quantidade'];

        if (isset($item['sabores']) && is_array($item['sabores'])) {
            $sabores = implode(", ", $item['sabores']);
        } else {
            $sabores = '';
        }

        $stmt = $conn->prepare("INSERT INTO pedidos (nome, cpf, telefone, forma_entrega, endereco, tamanho_pizza, sabores, quantidade, bebida, preco, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssdssd", $nome, $cpf, $telefone, $forma_entrega, $endereco, $item['tamanho'], $sabores, $item['quantidade'], $item['bebida'], $precoItem, $total);
        $stmt->execute();
    }

    // Limpar o carrinho após o pedido ser finalizado
    unset($_SESSION['carrinho']);
    $stmt->close();
    $conn->close();

    // Redirecionar para a página de sucesso
    header("Location: pedido_sucesso.php");
    exit();
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="styles/finalizar_pedido.css">
    <script>
        function toggleEndereco() {
            var formaEntrega = document.getElementById('forma_entrega').value;
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

        function validateForm() {
            var formaEntrega = document.getElementById('forma_entrega').value;

            if (formaEntrega === 'entrega') {
                var endereco = document.getElementById('endereco').value;
                if (!endereco) {
                    alert("Por favor, informe o endereço de entrega.");
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Finalizar Pedido</h1>

        <!-- Formulário com validação -->
        <form action="finalizar_pedido.php" method="POST" onsubmit="return validateForm();">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>

            <label for="forma_entrega">Forma de Entrega:</label>
            <select id="forma_entrega" name="forma_entrega" onchange="toggleEndereco()" required>
                <option value="">Selecione</option>
                <option value="entrega">Entrega</option>
                <option value="retirada">Retirada</option>
            </select>

            <div id="endereco_container" style="display: none;">
                <label for="endereco">Endereço de Entrega:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Rua, Número, Bairro">
            </div>

            <h2 id="total_container">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h2>

            <button type="submit">Finalizar Pedido</button>
        </form>
    </div>
</body>
</html>
