<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
</head>
<body>
    <h2>Cadastro de Produto</h2>
    <br/>
    <?php 
        $id = $_GET["id"];
        $nome = $_GET["nome"];
        $telefone = $_GET["telefone"];
        $quantidade = $_GET["quantidade"];
        $tamanho = $_GET["tamanho"];
        $sabores = $_GET["sabores"];
        $retirar = $_GET["retirar"];
        $metodo = $_GET["metodo"];
        $total = $_GET["total"];
        $status = $_GET["status"];
    ?>
    <form action="editarpedidocozinha.php?id=<?php echo $id; ?>" method="post">
        Nome: <input type="text" id="nome" name="nome" readonly value="<?php echo $nome; ?>" /><br/>        
        Telefone: <input type="text" id="telefone" name="telefone" readonly value="<?php echo $telefone; ?>" /><br/>
        Quantidade: <input type="text" id="quantidade" name="quantidade" readonly value="<?php echo $quantidade; ?>" /><br/>       
        Tamanho: <input type="text" id="tamanho" name="tamanho" readonly value="<?php echo $tamanho; ?>" /><br/>
        Sabores: <input type="text" id="sabores" name="sabores" readonly value="<?php echo $sabores; ?>" /><br/>
        Retirar: <input type="text" id="retirar" name="retirar" readonly value="<?php echo $retirar; ?>" /><br/>         
        Metódo de entrega: <input type="text" id="metodo" name="metodo" readonly value="<?php echo $metodo; ?>" /><br/>       
        Total: <input type="text" id="total" name="total" readonly value="<?php echo $total; ?>" /><br/>
        <label for="status">Status:</label>
        <select name="status" id="status">
        <option value="FAZENDO">FAZENDO</option>
        <option value="PRONTO">PRONTO</option>
        </select> 
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>