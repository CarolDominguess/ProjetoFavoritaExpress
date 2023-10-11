<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
</head>
<body>
    <h2>Cadastro de Produtos</h2>
    <br/>
    <!--formulário para cadastro de aluno, passando os parametro via post. -->
    <form action="inserirproduto.php" method="post">
        Nome: <input type="text" id="nome" name="nome"/><br/>        
        Quantidade: <input type="text" id="quantidade" name="quantidade"/><br/>
        Preço: <input type="text" id="preco" name="preco"/><br/>
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>