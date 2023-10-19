<?php
    include 'conexao.php';

    //recebe os parametros do formulário via Post
    $id = $_GET["id"];
    $tamanho = $_POST["tamanho"];
    $preco = $_POST["preco"];


    //Cria o SQL para alterar os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $alterar = "update precos set tamanho = '$tamanho', preco ='$preco' where id = $id";
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $alterar);

    //Redireciona para a pagina inicial.
    header("Location: listarproduto.php");
?>