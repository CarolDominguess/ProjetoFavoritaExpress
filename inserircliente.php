<?php
include 'conexao.php';

// Recebe os parâmetros do formulário via POST
$email = $_POST["email"];
$senha = $_POST["senha"];

// Valida o email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Email inválido, redirecione de volta ao formulário com uma mensagem de erro
    header("Location: cadastrocliente.php?erro=email_invalido");
    exit();
}

// Cria o SQL para inserir os dados do usuário no banco de dados (usando consulta preparada)
$inserir = "INSERT INTO usuarios (email, senha) VALUES (?, ?)";
$stmt = mysqli_prepare($conexao, $inserir);

if ($stmt === false) {
    die("Erro na consulta preparada: " . mysqli_error($conexao));
}

// Vincule os parâmetros e execute a consulta
mysqli_stmt_bind_param($stmt, "ss", $email, $senha);
if (mysqli_stmt_execute($stmt)) {
    // Redirecione para a página inicial após o sucesso
    header("Location: acesse.php");
} else {
    die("Erro ao executar a consulta: " . mysqli_error($conexao));
}

// Feche a consulta preparada e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conexao);
?>

