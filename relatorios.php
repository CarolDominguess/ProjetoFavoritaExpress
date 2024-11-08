<?php
session_start();
require_once('tcpdf/tcpdf.php');

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "sistemaunipar");
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Variáveis para armazenar resultados
$faturamento_total = 0;
$lucro_liquido = 0;
$margem_lucro = 0;
$pizzas_pequena = 0;
$pizzas_media = 0;
$pizzas_grande = 0;
$pizzas_gigante = 0;
$coca_cola = 0;
$guarana = 0;
$suco = 0;
$agua = 0;
$fanta = 0;
$agua_com_gas = 0;
$despesas = 5000; // Despesas fixas

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Faturamento total
    $sql_faturamento = "SELECT SUM(total) AS faturamento_total FROM pedidos WHERE data_pedido BETWEEN '$data_inicio' AND '$data_fim'";
    $result = $conn->query($sql_faturamento);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $faturamento_total = $row['faturamento_total'] ? $row['faturamento_total'] : 0;
    }

    // Quantidade de pizzas por tamanho
    $sql_pizzas = "SELECT tamanho_pizza, COUNT(*) AS quantidade FROM pedidos WHERE data_pedido BETWEEN '$data_inicio' AND '$data_fim' GROUP BY tamanho_pizza";
    $result = $conn->query($sql_pizzas);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            switch ($row['tamanho_pizza']) {
                case 'pequena':
                    $pizzas_pequena = $row['quantidade'];
                    break;
                case 'media':
                    $pizzas_media = $row['quantidade'];
                    break;
                case 'grande':
                    $pizzas_grande = $row['quantidade'];
                    break;
                case 'gigante':
                    $pizzas_gigante = $row['quantidade'];
                    break;
            }
        }
    }

    // Quantidade de bebidas
    $sql_bebidas = "SELECT bebida, COUNT(*) AS quantidade FROM pedidos WHERE data_pedido BETWEEN '$data_inicio' AND '$data_fim' GROUP BY bebida";
    $result = $conn->query($sql_bebidas);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $bebida = strtolower($row['bebida']);
            // Verificação mais flexível para as bebidas
            if (in_array($bebida, ['coca-cola', 'coca cola', 'coca_cola'])) {
                $coca_cola += $row['quantidade'];
            } elseif ($bebida == 'guarana') {
                $guarana += $row['quantidade'];
            } elseif ($bebida == 'suco-laranja' || $bebida == 'suco de laranja') {
                $suco += $row['quantidade'];
            } elseif (in_array($bebida, ['agua-sem-gas', 'agua', 'agua sem gas', 'agua sem-gás'])) {
                $agua += $row['quantidade'];
            } elseif ($bebida == 'fanta') {
                $fanta += $row['quantidade'];
            } elseif ($bebida == 'agua-com-gas') {
                $agua_com_gas += $row['quantidade'];
            }
        }
    }

    // Calcular lucro líquido e margem de lucro
    $lucro_liquido = $faturamento_total - $despesas;
    $margem_lucro = $faturamento_total > 0 ? ($lucro_liquido / $faturamento_total) * 100 : 0;

    // Geração do PDF
    ob_clean(); // Limpa qualquer saída anterior
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Sua Pizzaria');
    $pdf->SetTitle('Relatório Financeiro');
    $pdf->SetSubject('Relatório de Vendas');
    $pdf->SetKeywords('TCPDF, PDF, exemplo, teste, guia');

    // Configurações de página
    $pdf->SetMargins(15, 15, 15);
    $pdf->AddPage();

    // Adiciona imagem da pizzaria
    $pdf->Image('./imagens/logo.png', 20, 15, 35, '', 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);

    // Adiciona um espaço após a imagem
    $pdf->Ln(50); // Ajuste a altura conforme necessário

    // Estilo do conteúdo
    $pdf->SetFont('helvetica', 'B', 16);
    $html = '<h1 style="text-align:center;">Relatório Financeiro</h1>';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Informações financeiras
    $pdf->SetFont('helvetica', '', 12);
    $html = '
    <p><strong>Faturamento Total:</strong> R$ ' . number_format($faturamento_total, 2, ',', '.') . '</p>
    <p><strong>Despesas:</strong> R$ ' . number_format($despesas, 2, ',', '.') . '</p>
    <p><strong>Lucro Líquido:</strong> R$ ' . number_format($lucro_liquido, 2, ',', '.') . '</p>
    <p><strong>Margem de Lucro:</strong> ' . round($margem_lucro, 2) . '%</p>
    <h2 style="color: #d10000;">Vendas</h2>
    <p><strong>Quantidade de Pizzas Vendidas:</strong></p>
    <ul>
        <li>Pequena: ' . $pizzas_pequena . '</li>
        <li>Média: ' . $pizzas_media . '</li>
        <li>Grande: ' . $pizzas_grande . '</li>
        <li>Gigante: ' . $pizzas_gigante . '</li>
    </ul>
    <p><strong>Quantidade de Bebidas Vendidas:</strong></p>
    <ul>
        <li>Coca-Cola: ' . $coca_cola . '</li>
        <li>Guaraná: ' . $guarana . '</li>
        <li>Suco: ' . $suco . '</li>
        <li>Água: ' . $agua . '</li>
        <li>Fanta: ' . $fanta . '</li>
        <li>Água com Gás: ' . $agua_com_gas . '</li>
    </ul>
    ';
    $pdf->writeHTML($html, true, false, true, false, '');

    // Fecha e gera o PDF
    $pdf->Output('relatorio_financeiro.pdf', 'I');

    // Finaliza a conexão com o banco de dados
    $conn->close();
    exit; // Encerra o script após gerar o PDF
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório Financeiro Simples da Pizzaria</title>
    <link rel="stylesheet" href="styles/relatorio.css">
</head>
<body>
    <h1>Relatório Financeiro</h1>

    <form action="" method="POST">
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>

        <label for="data_fim">Data de Fim:</label>
        <input type="date" id="data_fim" name="data_fim" required>

        <button type="submit">Gerar Relatório</button>
    </form>
</body>
</html>
