<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorita Express</title>
    <link rel="stylesheet" href="./styles/stylescadastrocliente.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="cadastro">
        <form action="inserircliente.php" method="POST">
            <h1>CADASTRAR-SE</h1>
            <div class="caixas">
                <input type="text" name="email" placeholder="E-mail" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="caixas">
                <input type="password" name="senha" placeholder="Senha" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <button type="submit" class="btn">Cadastrar</button>
            <div class="registrar">
                <p>Ja tem conta? <a href="acesse.php">Faça login</a></p>
            </div>
        </form>
    </div>    
</body>
</html>
<?php
if (isset($_GET["erro"]) && $_GET["erro"] === "email_invalido") {
    echo "<span style='color: white;'>O email inserido é inválido.</span>";
}
?>