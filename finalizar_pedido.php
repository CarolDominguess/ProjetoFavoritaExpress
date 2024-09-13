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
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $forma_entrega = $_POST['forma_entrega'];

    // Crie o pedido finalizado (ainda não confirmamos aqui, apenas preparamos os dados)
    $pedido_finalizado = [
        'nome' => htmlspecialchars($nome),
        'cpf' => htmlspecialchars($cpf),
        'telefone' => htmlspecialchars($telefone),
        'forma_entrega' => htmlspecialchars($forma_entrega),
        'carrinho' => $_SESSION['carrinho'],
        'total' => array_sum(array_column($_SESSION['carrinho'], 'preco'))
    ];

    // Armazene os dados do pedido temporariamente na sessão para a próxima página de confirmação
    $_SESSION['pedido_em_confirmacao'] = $pedido_finalizado;

    if (isset($_SESSION['carrinho'])) {
        unset($_SESSION['carrinho']);
    }

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
    <link rel="stylesheet" href="./styles/finalizar_pedido.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
        }

        input, select {
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
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
            <select id="forma_entrega" name="forma_entrega" required>
                <option value="entrega">Entrega</option>
                <option value="retirada">Retirada</option>
            </select>
            
            <button type="submit">Finalizar Pedido</button>
        </form>
        
        <a href="visualizar_carrinho.php">Voltar ao Carrinho</a>
    </div>
</body>
</html>
