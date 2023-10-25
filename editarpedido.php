<?php
    include 'conexao.php';

    //recebe os parametros do formulário via Post
    $id = $_GET["id"];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $quantidade = $_POST["quantidade"];
    $tamanho = $_POST["tamanho"];
    $sabores = $_POST["sabores"];
    $retirar = $_POST["retirar"];
	$metodo = $_POST["metodo"];
    $total = $_POST["total"];
    $status = $_POST["status"];


    //Cria o SQL para alterar os dados do aluno no banco de dados, o ID não precisa porque é autoincrement.
    $alterar = "update pedido set nome = '$nome', telefone = '$telefone', quantidade ='$quantidade', tamanho ='$tamanho', sabores = '$sabores', retirar = '$retirar', metodo = '$metodo', total = '$total', status = '$status' where id = $id";
    //Executa o SQL no banco de dados da conexão.
    mysqli_query($conexao, $alterar);

    //Redireciona para a pagina inicial.
    header("Location: listarpedidos.php");
?>