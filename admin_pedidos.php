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

// Obter todos os pedidos, organizando do mais antigo para o mais recente
$sql = "SELECT * FROM pedidos ORDER BY id ASC";  // Ordena pelo id em ordem crescente (mais antigos primeiro)
$result = $conn->query($sql);

// Exibir pedidos
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Administração de Pedidos</title>
    <link rel="stylesheet" href="styles/admin_pedidos.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 90%; /* Aumenta a largura do container */
            max-width: 1200px; /* Limita a largura máxima */
            margin: auto; /* Centraliza o container */
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: none; /* Remove as bordas da tabela */
        }
        th {
            background-color: green; /* Cor de fundo para cabeçalho */
            color: white; /* Cor do texto do cabeçalho */
        }
        .remove-btn {
            color: red;
            cursor: pointer;
        }
    </style>
    <script>
        function removeRow(button) {
            // Obtém a linha (tr) correspondente ao botão clicado
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Pedidos Recebidos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Forma de Entrega</th>
                    <th>Endereço</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Exibe os pedidos na tabela
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td>{$row['nome']}</td>";
                        echo "<td>{$row['cpf']}</td>";
                        echo "<td>{$row['telefone']}</td>";
                        echo "<td>{$row['forma_entrega']}</td>";
                        echo "<td>{$row['endereco']}</td>";
                        echo "<td>R$ " . number_format($row['total'], 2, ',', '.') . "</td>";
                        echo "<td>{$row['data_pedido']}</td>";
                        echo "<td><a href='ver_pedido.php?id={$row['id']}'>Ver detalhes</a> | <span class='remove-btn' onclick='removeRow(this)'>Remover</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Nenhum pedido encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
