<?php
session_start();
include 'conexao.php'; // arquivo com a conexão ao banco de dados

// Verifica se o pedido em confirmação existe
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "Erro: Nenhum pedido para confirmar.";
    exit;
}

// Obtém os dados do pedido da sessão
$pedido = [
    'nome' => $_SESSION['nome'],
    'cpf' => $_SESSION['cpf'],
    'telefone' => $_SESSION['telefone'],
    'forma_entrega' => $_SESSION['forma_entrega'],
    'carrinho' => $_SESSION['carrinho'],
    'total' => array_sum(array_column($_SESSION['carrinho'], 'preco'))
];

// Armazena os dados do cliente
$nome = $pedido['nome'];
$cpf = $pedido['cpf'];
$telefone = $pedido['telefone'];
$forma_entrega = $pedido['forma_entrega'];
$total = $pedido['total'];

// Insere o pedido na tabela de pedidos
$query_pedido = "INSERT INTO pedidos (nome_cliente, cpf, telefone, forma_entrega, total) VALUES (?, ?, ?, ?, ?)";
$stmt_pedido = $conn->prepare($query_pedido);
$stmt_pedido->bind_param('ssssd', $nome, $cpf, $telefone, $forma_entrega, $total);

if ($stmt_pedido->execute()) {
    // Obtém o ID do pedido inserido
    $pedido_id = $conn->insert_id;

    // Insere os itens do pedido na tabela de itens_pedido
    $query_item = "INSERT INTO itens_pedido (pedido_id, produto, tamanho, sabor, bebida, quantidade, preco) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_item = $conn->prepare($query_item);

    foreach ($pedido['carrinho'] as $item) {
        $produto = $item['produto'];
        $tamanho = $item['tamanho'];
        $sabores = !empty($item['sabores']) ? implode(', ', $item['sabores']) : '';
        $bebidas = !empty($item['bebidas']) ? implode(', ', $item['bebidas']) : '';
        $quantidade = $item['quantidade'];
        $preco = $item['preco'];

        $stmt_item->bind_param('isssdd', $pedido_id, $produto, $tamanho, $sabores, $bebidas, $quantidade, $preco);
        $stmt_item->execute();
    }

    // Limpa
