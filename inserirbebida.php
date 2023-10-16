<?php
    include 'conexao.php';

    
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];

    
    $inserir = "insert into bebidas (nome, quantidade, validade, preco) values ('$nome', '$quantidade', '$validade', '$preco')";
    
    mysqli_query($conexao, $inserir);

    header("Location: listarproduto.php");
?>