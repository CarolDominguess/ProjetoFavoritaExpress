<?php
session_start();

// Verifique se há um pedido para processar
if (!isset($_SESSION['pedido_em_confirmacao'])) {
    echo "Erro: Nenhum pedido para processar.";
    exit;
}

// Obtenha os dados do pedido finalizado
$pedido = $_SESSION['pedido_em_confirmacao'];

// Aqui, você pode adicionar lógica para salvar o pedido no banco de dados ou enviar para outro sistema

// Após processar o pedido, adicione-o à lista de pedidos
if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = [];
}

$_SESSION['pedidos'][] = $pedido;

// Limpe os dados do pedido em confirmação e o carrinho
unset($_SESSION['pedido_em_confirmacao']);

// Redirecione para uma página de sucesso ou agradecimento
header('Location: pedido_finalizado.php');
exit;
?>
