<?php
    include 'conexao.php';

        $nome = $_POST["nome"];
        $telefone = $_POST["telefone"];
        $quantidade = $_POST["quantidade"];
        $tamanho = $_POST["tamanho"];
        $sabores = $_POST["sabores"];
        $retirar = $_POST["retirar"];
        $metodo = $_POST["metodo"];
        $total = $_POST["total"];
        $status = $_POST["status"];

    //Cria o SQL para inserir os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $inserir = "insert into pedido (nome, telefone, quantidade, tamanho, sabores, retirar, metodo, total, status) values ('$nome', '$telefone', '$quantidade', '$tamanho', '$sabores', '$retirar', '$metodo', '$total', '$status')"; 
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $inserir);

    //Redireciona para a pagina inicial.
    header("Location: listarpedidos.php");
?>