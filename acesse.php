
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/styleslogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="cadastro">
        <form action="" method="POST">
            <h1>Entrar</h1>
            <div class="caixas">
                <input type="text" name="email" placeholder="E-mail" required>
                <div class='bx bxs-user'></div>
            </div>
            <div class="caixas">
                <input type="password" name="senha" placeholder="Senha" required>
                <div class='bx bxs-lock-alt' ></div>
            </div>
            <div class="remember-forgot">
                <label> <input type="checkbox"> Remember me</label>
            </div>

            <button type="submit" class="btn">Entrar</button>
            <div class="registrar">
                <p>Não tem conta? <a href="cadastrocliente.php">Registre-se</a></p>
            </div>
        </form>
    </div>    
</body>
</html>


<?php
include('conexaoo.php');

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
        echo "<span style='color:white;'>Preencha seu e-mail</span>";
    } else if(strlen($_POST['senha']) == 0) {
        echo "<span style='color:white;'>Preencha sua senha</span>";
    } else {

        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: index.php");

        } 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
        
            // Use a função filter_var para validar o e-mail
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // O e-mail é válido, você pode prosseguir com o processamento do formulário
                echo "Email válido: " . $email;
                // Aqui você pode adicionar o código para lidar com o envio do formulário
            } else {
                // O e-mail não é válido, redirecione de volta ao formulário
                echo "<span style='color:white;'>O email inserido é inválido</span>";

            }
        }
        
        else {
            echo "<span style='color:white;'>Falha ao logar! E-mail ou senha incorretos</span>";
        }

    }

}
    	

?>