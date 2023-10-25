<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
	<link rel="stylesheet" href=".//styles.css">
</head>
<body>
	<h2 id="texto">Lista de precos</h2>
    <br/>
    <table id="tabela" border='1'>
    	<tr>
			<td><b>Código</b></td>
    		<td><b>Tamanho</b></td>
    		<td><b>Preço</b></td>
    		<td><b>Editar</b></td>
    		
    	</tr>
    	<!-- A partir daqui inicia a busca no banco de dados para trazer as bebidas nas linhas da tabela -->
    	<?php
		//cria uma conexão com o banco de dados
    	include 'conexao.php';
    	//executa uma query buscando todas as bebidas do banco de dados e atribui a variável "resultado"
    	$resultado = mysqli_query($conexao, "select * from precos");
    	//quebra o resultado em linhas e faz um laço de repetição para cada linha do resultado.
    	while($row = mysqli_fetch_array($resultado)){
    		//cada linha do resultado de aluno possui os atributos id, nome e ra, no qual estão sendo recuperados e atribuídos a nova variáveis locais.
			$id = $row["id"];
			$tamanho = $row["tamanho"];
    		$preco = $row["preco"];
    		

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
					<td>$id</td>
    				<td>$tamanho</td>
    				<td>$preco</td>
    				<td><a href='formeditarpreco.php?id=$id&tamanho=$tamanho&preco=$preco'>Editar</a></td>
    				
    			</tr>";
    	}
		?>  
    </table>
    <br/>
    
</body>
</html>