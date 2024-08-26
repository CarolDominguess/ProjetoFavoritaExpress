<?php
session_start();

// Inicializa o carrinho na sessão, se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Adiciona o pedido ao carrinho
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $produto = 'Pizza';
    $tamanho = $_POST['tamanho'];
    $sabores = $_POST['sabor'];
    $quantidade = $_POST['quantidade'];
    $tem_bebida = isset($_POST['tem_bebida']);
    $bebidas = $tem_bebida ? $_POST['bebida'] : [];

    // Define preços
    $precos_pizza = ['pequeno' => 35, 'médio' => 45, 'grande' => 55, 'gigante' => 75];
    $precos_bebida = ['coca-cola' => 7, 'agua' => 4, 'guarana' => 5, 'suco-laranja' => 9];

    // Calcula preço total
    $preco_pizza = $precos_pizza[$tamanho] * $quantidade;
    $preco_bebida = 0;
    foreach ($bebidas as $bebida) {
        $preco_bebida += $precos_bebida[$bebida];
    }
    $preco_total = $preco_pizza + $preco_bebida;

    // Adiciona ao carrinho
    $_SESSION['carrinho'][] = [
        'produto' => $produto,
        'tamanho' => $tamanho,
        'sabores' => $sabores,
        'quantidade' => $quantidade,
        'tem_bebida' => $tem_bebida,
        'bebidas' => $bebidas,
        'preco' => $preco_total
    ];

    header('Location: visualizar_carrinho.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faça Seu Pedido</title>
    <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="./styles/carrinho.css">
    <style>
        /* Adicione o CSS aqui */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .bebidas-container {
            display: none;
            margin-top: 10px;
        }

        .bebidas-container label {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Faça Seu Pedido</h1>
    <form action="carrinho.php" method="post">
        <table>
            <tr>
                <td>Produto: Pizza</td>
                <td>
                    Tamanho: 
                    <select name="tamanho" id="tamanho" onchange="atualizarCampos()">
                        <option value="pequeno">Pequeno</option>
                        <option value="médio">Médio</option>
                        <option value="grande">Grande</option>
                        <option value="gigante">Gigante</option>
                    </select>
                </td>
                <td>
                    Sabores:
                    <div id="sabores-container">
                        <select name="sabor[]" id="sabor">
                            <option value="mussarela">Mussarela</option>
                            <option value="calabresa">Calabresa</option>
                            <option value="portuguesa">Portuguesa</option>
                        </select>
                    </div>
                </td>
                <td>
                    Quantidade: <input type="number" name="quantidade" value="1" min="1">
                </td>
                <td>
                    Bebida: 
                    <input type="checkbox" name="tem_bebida" id="tem_bebida" onchange="toggleBebidas()">
                </td>
            </tr>
        </table>

        <div class="bebidas-container" id="bebidas-container">
            <h3>Escolha suas bebidas</h3>
            <label><input type="checkbox" name="bebida[]" value="coca-cola"> Coca-Cola (R$ 7,00)</label>
            <label><input type="checkbox" name="bebida[]" value="agua"> Água (R$ 4,00)</label>
            <label><input type="checkbox" name="bebida[]" value="guarana"> Guaraná (R$ 5,00)</label>
            <label><input type="checkbox" name="bebida[]" value="suco-laranja"> Suco de Laranja (R$ 9,00)</label>
        </div>

        <button type="submit">Adicionar ao Carrinho</button>
    </form>

    <script>
        function toggleBebidas() {
            var bebidasContainer = document.getElementById('bebidas-container');
            var checkbox = document.getElementById('tem_bebida');
            bebidasContainer.style.display = checkbox.checked ? 'block' : 'none';
        }

        function atualizarCampos() {
            var tamanho = document.getElementById('tamanho').value;
            var saboresContainer = document.getElementById('sabores-container');
            var quantidadeSabores = { pequeno: 1, médio: 2, grande: 3, gigante: 3 };

            saboresContainer.innerHTML = '';

            for (var i = 0; i < quantidadeSabores[tamanho]; i++) {
                var select = document.createElement('select');
                select.name = 'sabor[]';
                select.innerHTML = '<option value="mussarela">Mussarela</option><option value="calabresa">Calabresa</option><option value="portuguesa">Portuguesa</option>';
                saboresContainer.appendChild(select);
            }
        }

        // Inicialização ao carregar a página
        atualizarCampos();
    </script>
</body>
</html>
