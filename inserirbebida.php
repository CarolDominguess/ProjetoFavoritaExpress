<?php
    include 'conexao.php';

    
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];

    
    $inserir = "insert into bebidas (nome, quantidade, preco) values ('$nome', '$quantidade', '$preco')";
    
    mysqli_query($conexao, $inserir);

    header("Location: listarproduto.php");
?>