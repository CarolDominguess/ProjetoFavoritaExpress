<?php
// Conecte-se ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "sistemaunipar";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifique se o ID do pedido foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID do pedido inválido.");
}

$id_pedido = $_GET['id'];

// Obter detalhes do pedido a partir do ID
$sql = "SELECT * FROM pedidos WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação da consulta SQL: " . $conn->error);
}

// Bind do parâmetro
$stmt->bind_param("i", $id_pedido);

// Executa a consulta
$stmt->execute();

// Obter o resultado
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
} else {
    die("Pedido não encontrado.");
}

// Agora, precisamos verificar como os sabores, tamanho e bebida estão armazenados.
// Adapte o código abaixo de acordo com o formato exato dos dados na tabela `pedidos`.

// Exemplo de um array de sabores (caso seja um campo em que os sabores são armazenados como uma string separada por vírgulas)
$sabores = isset($pedido['sabores']) ? explode(",", $pedido['sabores']) : [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" href="styles/ver_pedido.css">
</head>
<body>
    <div class="container">
        <h1>Detalhes do Pedido</h1>

        <h2>Informações do Pedido</h2>
        <p>ID: <?php echo $pedido['id']; ?></p>
        <p>Nome: <?php echo htmlspecialchars($pedido['nome']); ?></p>
        <p>CPF: <?php echo htmlspecialchars($pedido['cpf']); ?></p>
        <p>Telefone: <?php echo htmlspecialchars($pedido['telefone']); ?></p>
        <p>Forma de Entrega: <?php echo ucfirst(htmlspecialchars($pedido['forma_entrega'])); ?></p>
        <p>Endereço: <?php echo htmlspecialchars($pedido['endereco']); ?></p>
        <p>Total: R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></p>
        <p>Data do Pedido: <?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></p>

        <h2>Detalhes dos Itens do Pedido</h2>
        <table>
            <thead>
                <tr>
                    <th>Pizza</th>
                    <th>Sabor(es)</th>
                    <th>Quantidade</th>
                    <th>Bebida</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Certifique-se de que 'tamanho', 'bebida', 'sabores' e 'quantidade' estão no banco de dados
                // Se não existirem, ajuste de acordo com a estrutura do banco
                $tamanho = isset($pedido['tamanho_pizza']) ? $pedido['tamanho_pizza'] : 'Indefinido';
                $bebida = isset($pedido['bebida']) ? $pedido['bebida'] : 'Sem bebidas';
                $quantidade = isset($pedido['quantidade']) ? $pedido['quantidade'] : 1;  // A quantidade pode vir da tabela
                $sabores_str = !empty($sabores) ? implode(", ", $sabores) : 'Sem sabores';

                // Calcular preço dos itens
                $precoPizza = calcularPrecoPizza($tamanho);  // Função de cálculo de pizza
                $precoBebida = calcularPrecoBebida($bebida);  // Função de cálculo de bebida
                $precoItem = ($precoPizza + $precoBebida) * $quantidade;  // Preço do item

                // Exibir os dados
                echo "<tr>";
                echo "<td>{$tamanho}</td>";
                echo "<td>{$sabores_str}</td>";
                echo "<td>{$quantidade}</td>";
                echo "<td>{$bebida}</td>";
                echo "<td>R$ " . number_format($precoItem, 2, ',', '.') . "</td>";
                echo "</tr>";
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

<?php
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
?>
