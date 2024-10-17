<?php
session_start();

// Conecte-se ao banco de dados
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "sistemaunipar"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Variáveis para armazenar resultados do relatório
$faturamento_total = 0;
$lucro_liquido = 0;
$margem_lucro = 0;
$pizzas_vendidas = [
    'pequena' => 0,
    'media' => 0,
    'grande' => 0,
    'gigante' => 0
];
$bebidas_vendidas = [
    'coca_cola' => 0,
    'guarana' => 0,
    'suco' => 0,
    'agua' => 0
];
$despesas = 0; // Despesas fixas (exemplo: 5000 R$) - ajuste conforme necessário

// Verificar se o formulário foi enviado e realizar a consulta de relatório
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os valores do formulário
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consultar o faturamento total
    $sql_faturamento = "SELECT SUM(total) AS faturamento_total 
                        FROM pedidos 
                        WHERE data BETWEEN ? AND ? AND status = 'ativo'";

    // Preparar e verificar se a consulta foi bem-sucedida
    $stmt = $conn->prepare($sql_faturamento);
    if ($stmt === false) {
        die("Erro ao preparar a consulta SQL: " . $conn->error);
    }

    // Bind dos parâmetros e execução da consulta
    $stmt->bind_param("ss", $data_inicio, $data_fim);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar se há resultados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faturamento_total = $row['faturamento_total'];
    } else {
        $faturamento_total = 0; // Caso não haja resultados
    }
    $stmt->close();

    // Consultar quantidade de pizzas vendidas por tamanho
    $sql_pizzas = "SELECT SUM(CASE WHEN tamanho = 'pequena' THEN 1 ELSE 0 END) AS pequenas,
                          SUM(CASE WHEN tamanho = 'media' THEN 1 ELSE 0 END) AS medias,
                          SUM(CASE WHEN tamanho = 'grande' THEN 1 ELSE 0 END) AS grandes,
                          SUM(CASE WHEN tamanho = 'gigante' THEN 1 ELSE 0 END) AS gigantes
                   FROM pedidos 
                   WHERE data BETWEEN ? AND ? AND status = 'ativo'";

    $stmt = $conn->prepare($sql_pizzas);
    if ($stmt === false) {
        die("Erro ao preparar a consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("ss", $data_inicio, $data_fim);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar se há resultados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pizzas_vendidas['pequena'] = $row['pequenas'];
        $pizzas_vendidas['media'] = $row['medias'];
        $pizzas_vendidas['grande'] = $row['grandes'];
        $pizzas_vendidas['gigante'] = $row['gigantes'];
    }
    $stmt->close();

    // Consultar quantidade de bebidas vendidas
    $sql_bebidas = "SELECT SUM(CASE WHEN bebida = 'Coca-Cola' THEN 1 ELSE 0 END) AS coca_cola,
                            SUM(CASE WHEN bebida = 'Guaraná' THEN 1 ELSE 0 END) AS guarana,
                            SUM(CASE WHEN bebida = 'Suco' THEN 1 ELSE 0 END) AS suco,
                            SUM(CASE WHEN bebida = 'Água' THEN 1 ELSE 0 END) AS agua
                    FROM pedidos 
                    WHERE data BETWEEN ? AND ? AND status = 'ativo'";

    $stmt = $conn->prepare($sql_bebidas);
    if ($stmt === false) {
        die("Erro ao preparar a consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("ss", $data_inicio, $data_fim);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verificar se há resultados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bebidas_vendidas['coca_cola'] = $row['coca_cola'];
        $bebidas_vendidas['guarana'] = $row['guarana'];
        $bebidas_vendidas['suco'] = $row['suco'];
        $bebidas_vendidas['agua'] = $row['agua'];
    }
    $stmt->close();

    // Calcular lucro líquido e margem de lucro
    $lucro_liquido = $faturamento_total - $despesas;
    $margem_lucro = ($lucro_liquido / $faturamento_total) * 100;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Financeiro da Pizzaria</title>
    <link rel="stylesheet" href="styles/relatorio.css">
</head>
<body>
    <div class="container">
        <h1>Relatório Financeiro</h1>

        <!-- Formulário para selecionar o período -->
        <form action="" method="POST">
            <label for="data_inicio">Data de Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" required>

            <label for="data_fim">Data de Fim:</label>
            <input type="date" id="data_fim" name="data_fim" required>

            <button type="submit">Gerar Relatório</button>
        </form>

        <!-- Exibir resultados do resumo financeiro -->
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="relatorio-financeiro">
                <h2>Resumo Financeiro</h2>
                <p><strong>Faturamento Total:</strong> R$ <?php echo number_format($faturamento_total, 2, ',', '.'); ?></p>
                <p><strong>Despesas:</strong> R$ <?php echo number_format($despesas, 2, ',', '.'); ?></p>
                <p><strong>Lucro Líquido:</strong> R$ <?php echo number_format($lucro_liquido, 2, ',', '.'); ?></p>
                <p><strong>Margem de Lucro:</strong> <?php echo number_format($margem_lucro, 2, ',', '.'); ?>%</p>
            </div>

            <div class="relatorio-vendas">
                <h2>Vendas</h2>
                <p><strong>Quantidade de Pizzas Vendidas:</strong></p>
                <ul>
                    <li>Pequena: <?php echo $pizzas_vendidas['pequena']; ?></li>
                    <li>Média: <?php echo $pizzas_vendidas['media']; ?></li>
                    <li>Grande: <?php echo $pizzas_vendidas['grande']; ?></li>
                    <li>Gigante: <?php echo $pizzas_vendidas['gigante']; ?></li>
                </ul>

                <p><strong>Quantidade de Bebidas Vendidas:</strong></p>
                <ul>
                    <li>Coca-Cola: <?php echo $bebidas_vendidas['coca_cola']; ?></li>
                    <li>Guaraná: <?php echo $bebidas_vendidas['guarana']; ?></li>
                    <li>Suco: <?php echo $bebidas_vendidas['suco']; ?></li>
                    <li>Água: <?php echo $bebidas_vendidas['agua']; ?></li>
                </ul>

                <p><strong>Vendas por Categoria:</strong></p>
                <ul>
                    <li>Pizzas: R$ <?php echo number_format($faturamento_total - array_sum($bebidas_vendidas), 2, ',', '.'); ?></li>
                    <li>Bebidas: R$ <?php echo number_format(array_sum($bebidas_vendidas), 2, ',', '.'); ?></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
