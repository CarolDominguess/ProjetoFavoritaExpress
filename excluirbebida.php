<?php
    
    include 'conexao.php';

    
    $id = $_GET["id"];

    $excluir = "delete from bebidas where id = $id";
    
    mysqli_query($conexao, $excluir);

    
    header("Location: listarproduto.php");
?>