<?php
session_start(); // Começa a sessão

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados do formulário
    $tamanho = $_POST['tamanho'];
    $sabores = $_POST['sabores'];
    $quantidade = $_POST['quantidade'];
    
    // Se o usuário escolheu uma bebida
    $bebida = isset($_POST['escolher_bebida']) ? $_POST['bebida'] : null;

    // Se o carrinho não existir, cria um novo
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Cria o pedido e adiciona no carrinho
    $pedido = [
        'tamanho' => $tamanho,
        'sabores' => $sabores,
        'quantidade' => $quantidade,
        'bebida' => $bebida, // Pode ser null se não houver bebida
    ];

    $_SESSION['carrinho'][] = $pedido; // Adiciona o pedido no carrinho

    // Vai para a página do carrinho
    header('Location: carrinho.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faça seu Pedido</title>
    <link rel="stylesheet" href="styles/pedido.css">
    <script>
        // Atualiza os sabores da pizza com base no tamanho
        function atualizarSabores() {
            var tamanho = document.getElementById('tamanho').value;
            var saboresContainer = document.getElementById('sabores_container');

            // Limpa os sabores antigos
            saboresContainer.innerHTML = '';

            // Define quantos sabores escolher
            var numSabores = tamanho === 'pequena' ? 1 : (tamanho === 'media' ? 2 : (tamanho === 'grande' ? 3 : 4));

            // Adiciona os campos de sabores
            for (var i = 1; i <= numSabores; i++) {
                var label = document.createElement('label');
                label.innerHTML = 'Sabor ' + i + ':';

                var select = document.createElement('select');
                select.name = 'sabores[]';
                select.required = true;

                // Lista de sabores
                var sabores = [
                    'Banana Caramelizada',
                    'Brocolis com bacon',
                    'Burrata',
                    'Charge',
                    'CheeseCake',
                    'Chocolate ao Leite com M&M´s',
                    'Chocolate Branco com M&M´s',
                    'Filé de frango com champignon',
                    'Frango Exótico',
                    'Lombo Canadense',
                    'Levíssimo Seara',
                    'Marguerita Especial',
                    'Marshmallow com Kit Kat®',
                    'Pepperoni',
                    'Presunto Alemão com Tomate Cereja',
                    'Presunto com Champignon',
                    'Quatro Queijos',
                    'Romeu e Julieta',
                    'Sensação',
                    'Tomate Seco com Rúcula'
                ];

                // Adiciona os sabores ao select
                sabores.forEach(function(sabor) {
                    var option = document.createElement('option');
                    option.value = sabor;
                    option.text = sabor;
                    select.appendChild(option);
                });

                // Adiciona o campo de sabor ao container
                saboresContainer.appendChild(label);
                saboresContainer.appendChild(select);
                saboresContainer.appendChild(document.createElement('br'));
            }
        }

        // Mostra ou esconde a seção de bebidas
        function toggleBebida() {
            var checkbox = document.getElementById('escolher_bebida');
            var bebidasContainer = document.getElementById('bebidas_container');
            bebidasContainer.style.display = checkbox.checked ? 'block' : 'none'; // Mostra ou esconde
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Escolha sua Pizza</h1>
        <form action="pedido.php" method="POST">
            <label for="tamanho">Tamanho da Pizza:</label>
            <select id="tamanho" name="tamanho" onchange="atualizarSabores()" required>
                <option value="pequena">Pequena</option>
                <option value="media">Média</option>
                <option value="grande">Grande</option>
                <option value="gigante">Gigante</option>
            </select>

            <div id="sabores_container">
                <!-- Campos de sabores vão aqui -->
            </div>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" min="1" value="1" required>

            <label for="escolher_bebida">Deseja uma bebida?</label>
            <input type="checkbox" id="escolher_bebida" name="escolher_bebida" onclick="toggleBebida()">

            <div id="bebidas_container" style="display: none;">
                <label for="bebida">Escolha sua bebida:</label>
                <select id="bebida" name="bebida">
                    <option value="coca-cola">Coca-Cola (lata): R$ 5,00</option>
                    <option value="fanta">Fanta (lata): R$ 5,00</option>
                    <option value="guarana">Guaraná (lata): R$ 4,00</option>
                    <option value="suco-laranja">Suco de Laranja (300 ml): R$ 8,00</option>
                    <option value="agua-sem-gas">Água mineral (500 ml): R$ 3,00</option>
                    <option value="agua-com-gas">Água com gás: R$ 4,00</option>
                </select>
            </div>

            <button type="submit">Adicionar ao Carrinho</button>
        </form>
    </div>

    <script>
        // Chama a função para atualizar os sabores quando a página carrega
        atualizarSabores();
    </script>
</body>
</html>
