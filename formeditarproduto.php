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
    	$quantidade = $_GET["quantidade"];
        $preco = $_GET["preco"];
    ?>
    <form action="editarproduto.php?id=<?php echo $id; ?>" method="post">
        Nome: <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" /><br/>        
        Quantidade: <input type="text" id="quantidade" name="quantidade" value="<?php echo $quantidade; ?>" /><br/>       
        Preço: <input type="text" id="preco" name="preco" value="<?php echo $preco; ?>" /><br/>
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>