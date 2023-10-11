<?php
    include 'conexao.php';

    //recebe os parametros do formulário via Post
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];

    //Cria o SQL para inserir os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $inserir = "insert into produto (nome, quantidade, preco) values ('$nome', '$quantidade', '$preco')";
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $inserir);

    //Redireciona para a pagina inicial.
    header("Location: listarproduto.php");
?>