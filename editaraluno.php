<?php
    include 'conexao.php';

    //recebe os parametros do formulário via Post
    $id = $_GET["id"];
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];


    //Cria o SQL para alterar os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $alterar = "update produto set nome = '$nome', quantidade ='$quantidade', preco = '$preco' where id = $id";
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $alterar);

    //Redireciona para a pagina inicial.
    header("Location: listaraluno.php");
?>