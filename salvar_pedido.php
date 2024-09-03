<?php
session_start();

if (!isset($_SESSION['pedido_finalizado'])) {
    echo "Nenhum pedido para salvar.";
    exit;
}

// Conexão com o banco de dados
$servername = "localhost"; // ou o IP do seu servidor
$username = "root"; // seu usuário do banco de dados
$password = ""; // sua senha do banco de dados
$dbname = "pizzaria"; // o nome do banco de dados que você criou

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtendo os dados do pedido
$nome = $_SESSION['pedido_finalizado']['nome'];
$cpf = $_SESSION['pedido_finalizado']['cpf'];
$telefone = $_SESSION['pedido_finalizado']['telefone'];
$forma_entrega = $_SESSION['pedido_finalizado']['forma_entrega'];
$total = $_SESSION['pedido_finalizado']['total'];

foreach ($_SESSION['pedido_finalizado']['carrinho'] as $item) {
    $produto = $item['produto'];
    $tamanho = ucfirst($item['tamanho']);
    $sabores = !empty($item['sabores']) ? implode(', ', $item['sabores']) : 'Nenhum sabor';
    $bebidas = !empty($item['bebidas']) ? implode(', ', $item['bebidas']) : 'Nenhuma bebida';
    $quantidade = $item['quantidade'];
    $preco = $item['preco'];

    // SQL para inserir o pedido na tabela
    $sql = "INSERT INTO pedidos (nome, cpf, telefone, forma_entrega, produto, tamanho, sabores, bebidas, quantidade, preco, total) 
            VALUES ('$nome', '$cpf', '$telefone', '$forma_entrega', '$produto', '$tamanho', '$sabores', '$bebidas', $quantidade, $preco, $total)";

    if ($conn->query($sql) === TRUE) {
        echo "Pedido salvo com sucesso!";
    } else {
        echo "Erro ao salvar o pedido: " . $conn->error;
    }
}

// Limpa a sessão após salvar os dados
unset($_SESSION['pedido_finalizado']);

// Fecha a conexão
$conn->close();
?>
