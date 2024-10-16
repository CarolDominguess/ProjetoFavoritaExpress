<?php
session_start();

// Verifique se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifique se o carrinho está definido e não está vazio
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        echo "Erro: O carrinho está vazio.";
        exit;
    }

    // Receba os dados do cliente
    $nome = htmlspecialchars($_POST['nome']);
    $cpf = htmlspecialchars($_POST['cpf']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $forma_entrega = htmlspecialchars($_POST['forma_entrega']);

    // Inicialize a variável do endereço e da taxa de entrega
    $endereco = null;
    $taxa_entrega = 0;

    // Se for entrega, receba o endereço e adicione a taxa de entrega
    if ($forma_entrega === 'entrega') {
        if (isset($_POST['endereco']) && !empty($_POST['endereco'])) {
            $endereco = htmlspecialchars($_POST['endereco']);
            $taxa_entrega = 7.00; // Taxa de entrega
        } else {
            echo "Erro: O campo de endereço é obrigatório para entrega.";
            exit;
        }
    }

    // Calcular o total do pedido, incluindo a taxa de entrega, se aplicável
    $total_pedido = array_sum(array_column($_SESSION['carrinho'], 'preco')) + $taxa_entrega;

    // Crie o pedido finalizado (ainda não confirmamos aqui, apenas preparamos os dados)
    $pedido_finalizado = [
        'nome' => $nome,
        'cpf' => $cpf,
        'telefone' => $telefone,
        'forma_entrega' => $forma_entrega,
        'endereco' => $endereco,
        'carrinho' => $_SESSION['carrinho'],
        'taxa_entrega' => $taxa_entrega,
        'total' => $total_pedido
    ];

    // Armazene os dados do pedido temporariamente na sessão para a próxima página de confirmação
    $_SESSION['pedido_em_confirmacao'] = $pedido_finalizado;

    // Limpe o carrinho após finalizar o pedido
    unset($_SESSION['carrinho']);

    // Redirecione para a página de confirmação do pedido
    header('Location: confirmar_pedido.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Pedido</title>
    <link rel="stylesheet" href="styles/finalizar_pedido.css"> <!-- Link para o CSS externo -->
    <script>
        // Função para exibir/esconder o campo de endereço com base na opção de entrega selecionada
        function toggleEnderecoField() {
            var formaEntrega = document.getElementById('forma_entrega').value;
            var enderecoField = document.getElementById('endereco_field');

            // Mostrar o campo de endereço apenas se a forma de entrega for "Entrega"
            if (formaEntrega === 'entrega') {
                enderecoField.style.display = 'block';
            } else {
                enderecoField.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Finalizar Pedido</h1>

        <form action="finalizar_pedido.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>
            
            <label for="forma_entrega">Forma de Entrega:</label>
            <select id="forma_entrega" name="forma_entrega" required onchange="toggleEnderecoField()">
                <option value="retirada">Retirada</option>
                <option value="entrega">Entrega</option>
            </select>
            
            <!-- Campo de endereço que aparecerá apenas quando a opção "Entrega" for selecionada -->
            <div id="endereco_field">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco">
            </div>

            <button type="submit">Finalizar Pedido</button>
        </form>
        
        <a href="visualizar_carrinho.php">Voltar ao Carrinho</a>
    </div>
</body>
</html>
