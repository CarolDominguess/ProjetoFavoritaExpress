<<?php
    include 'conexao.php';

    //recebe os parametros do formulário via Post
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    //Cria o SQL para inserir os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $inserir = "insert into usuarios (email, senha) values ('$email', '$senha')";
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $inserir);

    //Redireciona para a pagina inicial.
    header("Location: acesse.php");
?>
