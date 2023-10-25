<?php
    //cria uma conexao com o banco de dados.
    include 'conexao.php';

    //recebe por parametro via GET o id do aluno que deseja excluir
    $id = $_GET["id"];
    //cria uma variavel com a SQL que será executado no banco de dados.
    //o SQL delete vai excluir o aluno com o ID passado por parametro.
    $excluir = "delete from pedido where id = $id";
    //Executa a query de delete no banco de dados, através da conexão passada por parametro.
    mysqli_query($conexao, $excluir);

    //Redireciona para a pagina inicial.
    header("Location: listarpedidos.php");
?>