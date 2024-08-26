<?php
session_start();

// Verifica se o carrinho existe
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

// Recebe os dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$forma_entrega = $_POST['forma_entrega'];
$valor_total = array_sum(array_column($_SESSION['carrinho'], 'preco'));

// Aqui você pode salvar os dados no banco de dados ou enviar um e-mail para a pizzaria
// Exemplo de processamento (não implementado neste código):
// saveOrder($nome, $cpf, $telefone, $forma_entrega, $valor_total, $_SESSION['carrinho']);

// Limpa o carrinho após a confirmação
unset($_SESSION['carrinho']);

echo "<h1>Pedido Confirmado</h1>";
echo "<p>Obrigado, $nome! Seu pedido foi confirmado com sucesso.</p>";
echo "<p>Valor Total: R$ " . number_format($valor_total, 2, ',', '.') . "</p>";
echo "<p><a href='carrinho.php'>Fazer Novo Pedido</a></p>";
?>
