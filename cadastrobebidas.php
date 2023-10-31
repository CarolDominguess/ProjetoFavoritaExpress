<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Favorita Express</title>
</head>
<body>
    <h2>Cadastro de Produtos</h2>
    <br/>
    <!--formulário para cadastro de aluno, passando os parametro via post. -->
    <form action="inserirbebida.php" method="post">
        Nome: <input type="text" id="nome" name="nome"/><br/>        
        Quantidade: <input type="text" id="quantidade" name="quantidade"/><br/>
        Validade: <input type="text" id="validade" name="validade"/><br/>
        Preço: <input type="text" id="preco" name="preco"/><br/>
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>