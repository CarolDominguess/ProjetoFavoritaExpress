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
        <label for="tamanho">Tamanho:</label>
        <select name="tamanho" id="tamanho">
        <option value="PEQUENA">PEQUENA</option>
        <option value="MÉDIA">MÉDIA</option>
        <option value="GRANDE">GRANDE</option>
        <option value="GIGANTE">GIGANTE</option>
        </select><br/> 
        Sabores: <input type="text" id="sabores" name="sabores"/><br/>        
        Retirar: <input type="text" id="retirar" name="retirar"/><br/>
        <label for="metodo">Método de entrega:</label>
        <select name="metodo" id="metodo">
        <option value="ENTREGA">ENTREGA</option>
        <option value="RETIRADA">RETIRADA</option>
        </select><br/> 
        Endereço de entrega: <input type="text" id="endereco" name="endereco"/><br/>
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