<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Favorita Express</title>
</head>
<body>
    <h2>Cadastro de Preço</h2>
    <br/>
    <?php 
        $id = $_GET["id"];
    	$tamanho = $_GET["tamanho"];
        $preco = $_GET["preco"];
    ?>
    <form action="editarpreco.php?id=<?php echo $id; ?>" method="post">
        Tamanho: <input type="text" id="tamanho" name="tamanho" value="<?php echo $tamanho; ?>" /><br/>         
        Preço: <input type="text" id="preco" name="preco" value="<?php echo $preco; ?>" /><br/>
        <input type="submit" value="Salvar"/>
    </form>
</body>
</html>