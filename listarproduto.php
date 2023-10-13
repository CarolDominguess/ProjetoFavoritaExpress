<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
	<link rel="stylesheet" href=".//styles.css">
</head>
<body>
    <h2>Lista de Ingredientes</h2>
    <br/>
    <table border='1'>
    	<tr>
    		<td><b>Código</b></td>
    		<td><b>Nome</b></td>
    		<td><b>Quantidade</b></td>
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
			$preco = $row["preco"];

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
    				<td>$id</td>
    				<td>$nome</td>
    				<td>$quantidade</td>
					<td>$preco</td>
    				<td><a href='formeditarproduto.php?id=$id&nome=$nome&quantidade=$quantidade&preco=$preco'>Editar</a></td>
    				<td><a href='excluirproduto.php?id=$id'>Excluir</a></td>
    			</tr>";
    	}
    	?>    
    </table>
	<a href="cadastroproduto.php">Novo Produto</a> <br><br><br>
	<a href="index.php">Me leve de volta</a>
	<h2>Lista de Bebidas</h2>
    <br/>
    <table border='1'>
    	<tr>
    		<td><b>Código</b></td>
    		<td><b>Nome</b></td>
    		<td><b>Quantidade</b></td>
			<td><b>Preço</b></td>
    		<td><b>Editar</b></td>
    		<td><b>Excluir</b></td>
    	</tr>
    	<!-- A partir daqui inicia a busca no banco de dados para trazer os alunos nas linhas da tabela -->
    	<?php
    	//cria uma conexão com o banco de dados
    	include 'conexao.php';
    	//executa uma query buscando todos os alunos do banco de dados e atribui a variável "resultado"
    	$resultado = mysqli_query($conexao, "select * from bebidas");
    	//quebra o resultado em linhas e faz um laço de repetição para cada linha do resultado.
    	while($row = mysqli_fetch_array($resultado)){
    		//cada linha do resultado de aluno possui os atributos id, nome e ra, no qual estão sendo recuperados e atribuídos a nova variáveis locais.
    		$id = $row["id"];
    		$nome = $row["nome"];
    		$quantidade = $row["quantidade"];
			$preco = $row["preco"];

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
    				<td>$id</td>
    				<td>$nome</td>
    				<td>$quantidade</td>
					<td>$preco</td>
    				<td><a href='formeditarbebida.php?id=$id&nome=$nome&quantidade=$quantidade&preco=$preco'>Editar</a></td>
    				<td><a href='excluirbebida.php?id=$id'>Excluir</a></td>
    			</tr>";
    	}
    	?>    
    </table>
    <br/>
    <!-- Link para uma nova pagina de cadastro de aluno. -->
    <a href="cadastrobebidas.php">Novo Produto</a> <br><br><br>
	<a href="index.php">Me leve de volta</a>
</body>
</html>