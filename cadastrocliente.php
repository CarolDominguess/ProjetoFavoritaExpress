<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/stylescadastrocliente.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="inserircliente.php" method="POST">
            <h1>Cadastrar-se</h1>
            <div class="input-box">
                <input type="text" name="email" placeholder="E-mail" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="senha" placeholder="Senha" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>

            <button type="submit" class="btn">Cadastrar</button>
            <div class="register-link">
                <p>Ja tem conta? <a href="acesse.php">Faça login</a></p>
            </div>
        </form>
    </div>    
</body>
</html>
