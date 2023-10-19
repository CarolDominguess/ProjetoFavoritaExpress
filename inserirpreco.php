<?php
    include 'conexao.php';

    
    $tamanho = $_POST["tamanho"];
    $preco = $_POST["preco"];

    
    $inserir = "insert into precos (tamanho, preco) values ('$tamanho', '$preco')";
    
    mysqli_query($conexao, $inserir);

    header("Location: listarproduto.php");
?>