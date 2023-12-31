<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Favorita Express</title>
	<link rel="stylesheet" href="./styles/estoque.css">
	
</head>
<body>
	<h2 id="textestoque">ESTOQUE</h2>
    <h2 id="textingredientes1">Lista de Ingredientes</h2>
    <br/>

    <table id="tabela1" border='1'>
    	<tr>
    		<td><b>Código</b></td>
    		<td><b>Nome</b></td>
    		<td><b>Quantidade</b></td>
			<td><b>Validade</b></td>
			<td><b>Preço</b></td>
    		<td><b>Editar</b></td>
    		<td><b>Excluir</b></td>
    	</tr>
    	<!-- A partir daqui inicia a busca no banco de dados para trazer os alunos nas linhas da tabela -->
    	<?php
    	//cria uma conexão com o banco de dados
    	include 'conexao.php';
    	//executa uma query buscando todos os alunos do banco de dados e atribui a variável "resultado"
    	$resultado = mysqli_query($conexao, "select * from produto");
    	//quebra o resultado em linhas e faz um laço de repetição para cada linha do resultado.
    	while($row = mysqli_fetch_array($resultado)){
    		//cada linha do resultado de aluno possui os atributos id, nome e ra, no qual estão sendo recuperados e atribuídos a nova variáveis locais.
    		$id = $row["id"];
    		$nome = $row["nome"];
    		$quantidade = $row["quantidade"];
			$validade = $row["validade"];
			$preco = $row["preco"];

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
    				<td>$id</td>
    				<td>$nome</td>
    				<td>$quantidade</td>
					<td>$validade</td>
					<td>$preco</td>
    				<td><a id='editar' href='formeditarproduto.php?id=$id&nome=$nome&quantidade=$quantidade&validade=$validade&preco=$preco'>Editar</a></td>
    				<td><a id='excluir' href='excluirproduto.php?id=$id'>Excluir</a></td>
    			</tr>";
    	}
    	?>    
    </table>
	<br>
	<div id="links1">
	<a href="cadastroproduto.php">Novo Produto</a> <br><br><br>
	</div>

	<h2 id="textingredientes2">Lista de Bebidas</h2>
    <br/>
    <table id="tabela2" border='1'>
    	<tr>
    		<td><b>Código</b></td>
    		<td><b>Nome</b></td>
    		<td><b>Quantidade</b></td>
			<td><b>Validade</b></td>
			<td><b>Preço</b></td>
    		<td><b>Editar</b></td>
    		<td><b>Excluir</b></td>
    	</tr>
    	<!-- A partir daqui inicia a busca no banco de dados para trazer as bebidas nas linhas da tabela -->
    	<?php
    	//cria uma conexão com o banco de dados
    	include 'conexao.php';
    	//executa uma query buscando todas as bebidas do banco de dados e atribui a variável "resultado"
    	$resultado = mysqli_query($conexao, "select * from bebidas");
    	//quebra o resultado em linhas e faz um laço de repetição para cada linha do resultado.
    	while($row = mysqli_fetch_array($resultado)){
    		//cada linha do resultado de aluno possui os atributos id, nome e ra, no qual estão sendo recuperados e atribuídos a nova variáveis locais.
    		$id = $row["id"];
    		$nome = $row["nome"];
    		$quantidade = $row["quantidade"];
			$validade = $row["validade"];
			$preco = $row["preco"];

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
    				<td>$id</td>
    				<td>$nome</td>
    				<td>$quantidade</td>
					<td>$validade</td>
					<td>$preco</td>
    				<td><a id='editar' href='formeditarbebida.php?id=$id&nome=$nome&quantidade=$quantidade&validade=$validade&preco=$preco'>Editar</a></td>
    				<td><a id='excluir' href='excluirbebida.php?id=$id'>Excluir</a></td>
    			</tr>";
    	}
    	?>    
    </table>
    <br/>
	<div id="link2">
    <a href="cadastrobebidas.php">Novo Produto</a> <br><br>
	</div>
	<a id="link" href="paineladmin.php"><p id="text">Me leve de volta</p></a><br><br>
</body>
</html>