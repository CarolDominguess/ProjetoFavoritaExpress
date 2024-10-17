<?php
session_start(); // Inicia a sessão

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tamanho = $_POST['tamanho'];
    $sabores = $_POST['sabores'];
    $quantidade = $_POST['quantidade'];
    $bebida = isset($_POST['bebida']) ? $_POST['bebida'] : 'Nenhuma';

    // Inicialize o carrinho se não estiver configurado
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Adicione o pedido ao carrinho
    $pedido = [
        'tamanho' => $tamanho,
        'sabores' => $sabores,
        'quantidade' => $quantidade,
        'bebida' => $bebida,
    ];

    // Adiciona o pedido ao array de carrinho
    $_SESSION['carrinho'][] = $pedido;

    // Verifique se o pedido foi realmente adicionado ao carrinho
    if (!empty($_SESSION['carrinho'])) {
        // Redirecionar para a página de visualização do carrinho
        header('Location: carrinho.php');
        exit;
    } else {
        echo "Erro: Não foi possível adicionar o pedido ao carrinho.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faça seu Pedido</title>
    <link rel="stylesheet" href="styles/pedido.css">
    <script>
        function atualizarSabores() {
            var tamanho = document.getElementById('tamanho').value;
            var saboresContainer = document.getElementById('sabores_container');

            // Limpar os sabores atuais
            saboresContainer.innerHTML = '';

            var numSabores = 1; // padrão para pizza pequena
            if (tamanho === 'media') numSabores = 2;
            else if (tamanho === 'grande') numSabores = 3;
            else if (tamanho === 'gigante') numSabores = 4;

            // Criar campos de sabores com base no tamanho
            for (var i = 1; i <= numSabores; i++) {
                var label = document.createElement('label');
                label.innerHTML = 'Sabor ' + i + ':';

                var select = document.createElement('select');
                select.name = 'sabores[]';
                select.required = true;

                // Opções de sabores
                var sabores = ['Calabresa', 'Queijo', 'Hortelã', 'Frango com Catupiry', 'Atum'];
                sabores.forEach(function(sabor) {
                    var option = document.createElement('option');
                    option.value = sabor;
                    option.text = sabor;
                    select.appendChild(option);
                });

                saboresContainer.appendChild(label);
                saboresContainer.appendChild(select);
                saboresContainer.appendChild(document.createElement('br'));
            }
        }

        function toggleBebida() {
            var checkbox = document.getElementById('escolher_bebida');
            var bebidasContainer = document.getElementById('bebidas_container');
            bebidasContainer.style.display = checkbox.checked ? 'block' : 'none';
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
                <!-- Campos de sabores serão gerados dinamicamente aqui -->
            </div>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" min="1" value="1" required>

            <label for="escolher_bebida">Deseja uma bebida?</label>
            <input type="checkbox" id="escolher_bebida" name="escolher_bebida" onclick="toggleBebida()">

            <div id="bebidas_container" style="display: none;">
                <label for="bebida">Escolha sua bebida:</label>
                <select id="bebida" name="bebida">
                    <option value="coca-cola">Coca-Cola</option>
                    <option value="fanta">Fanta</option>
                    <option value="guarana">Guaraná</option>
                    <option value="suco-laranja">Suco de Laranja</option>
                </select>
            </div>

            <button type="submit">Adicionar ao Carrinho</button>
        </form>
    </div>
</body>
</html>
