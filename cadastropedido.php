<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
</head>
<body>
    <h2>Cadastro de Pedido</h2>
    <br/>
    <!--formulário para cadastro de aluno, passando os parametro via post. -->
    <form action="inserirpedido.php" method="post">
        Nome: <input type="text" id="nome" name="nome"/><br/>        
        Telefone: <input type="text" id="telefone" name="telefone"/><br/>
        Quantidade: <input type="text" id="quantidade" name="quantidade"/><br/>
        Tamanho: <input type="text" id="tamanho" name="tamanho"/><br/>
        Sabores: <input type="text" id="sabores" name="sabores"/><br/>        
        Retirar: <input type="text" id="retirar" name="retirar"/><br/>
        Método: <input type="text" id="metodo" name="metodo"/><br/>
        Total: <input type="text" id="total" name="total"/><br/> 
        <label for="status">Status:</label>
        <select name="status" id="status">
        <option value="FAZENDO">FAZENDO</option>
        <option value="PRONTO">PRONTO</option>
        </select><br/> <br/> 
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>