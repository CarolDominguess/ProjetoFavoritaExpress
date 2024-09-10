<?php
session_start();

// Defina a variável de controle antes de acessar a página de pedidos
$_SESSION['acesso_pedidos'] = true;

// Redirecione para a página de pedidos
header('Location: pedidos_pizzaria.php');
exit;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorita Express</title>
    <link rel="stylesheet" href="./styles/painel.css">
</head>
<body>
    <div id="links">
    <a href="listarproduto.php">ESTOQUE DE PRODUTOS</a> <br><br>
	<a href="listarpedidos.php">PAINEL DE PEDIDOS</a><br><br>
    <a href="pedidos_pizzaria.php">PAINEL DA COZINHA</a><br><br>
	<a href="listaralteracoes.php">ALTERAR PREÇOS</a><br><br>
    <a href="pedidos_funcionarios.php">PEDIDOS</a><br><br>
	<a href="index.php">SAIR</a>
    </div>
</body>
</html>