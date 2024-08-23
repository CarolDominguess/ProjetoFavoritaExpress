<?php
session_start();

// Inicializa o carrinho se não estiver definido
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Captura os dados do formulário
$produto = 'Pizza Margherita'; // Exemplo fixo, pode ser ajustado conforme necessário
$tamanho = $_POST['tamanho'];
$sabores = isset($_POST['sabor']) ? $_POST['sabor'] : array();
$tem_bebida = isset($_POST['tem_bebida']);
$bebidas = isset($_POST['bebida']) ? $_POST['bebida'] : array();
$quantidade = $_POST['quantidade'];
$preco = 30.00; // Exemplo fixo, pode ser ajustado conforme necessário

// Adiciona o item ao carrinho
$_SESSION['carrinho'][] = array(
    'produto' => $produto,
    'tamanho' => $tamanho,
    'sabores' => $sabores,
    'tem_bebida' => $tem_bebida,
    'bebidas' => $bebidas,
    'quantidade' => $quantidade,
    'preco' => $preco * $quantidade
);

// Redireciona para a página de visualização do carrinho
header('Location: visualizar_carrinho.php');
exit;
?>
