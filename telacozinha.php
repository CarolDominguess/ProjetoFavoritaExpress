<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Sistema Unipar</title>
	<link rel="stylesheet" href=".//styles.css">
	
</head>
<body>
    <h2>Tela Cozinha</h2>
    <br/>
    <table border='1'>
    	<tr>
    		<td><b>Código</b></td>
    		<td><b>Nome</b></td>
			<td><b>Telefone</b></td>
    		<td><b>Quantidade</b></td>
			<td><b>Tamanho</b></td>
			<td><b>Sabores</b></td>
			<td><b>Retirar ingrediente</b></td>
			<td><b>Método de entrega</b></td>
			<td><b>Total</b></td>
			<td><b>Status</b></td>
    		<td><b>Editar</b></td>
    	</tr>
    	<!-- A partir daqui inicia a busca no banco de dados para trazer os alunos nas linhas da tabela -->
    	<?php
    	//cria uma conexão com o banco de dados
    	include 'conexao.php';
    	//executa uma query buscando todos os alunos do banco de dados e atribui a variável "resultado"
    	$resultado = mysqli_query($conexao, "select * from pedido");
    	//quebra o resultado em linhas e faz um laço de repetição para cada linha do resultado.
    	while($row = mysqli_fetch_array($resultado)){
    		//cada linha do resultado de aluno possui os atributos id, nome e ra, no qual estão sendo recuperados e atribuídos a nova variáveis locais.
    		$id = $row["id"];
    		$nome = $row["nome"];
    		$telefone = $row["telefone"];
			$quantidade = $row["quantidade"];
    		$tamanho = $row["tamanho"];
    		$sabores = $row["sabores"];
			$retirar = $row["retirar"];
			$metodo = $row["metodo"];
    		$total = $row["total"];
    		$status = $row["status"];
	

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>
    				<td>$id</td>
    				<td>$nome</td>
    				<td>$telefone</td>
					<td>$quantidade</td>
					<td>$tamanho</td>
					<td>$sabores</td>
					<td>$retirar</td>
    				<td>$metodo</td>
    				<td>$total</td>
					<td>$status</td>
    				<td><a href='formeditarpedidocozinha.php?id=$id&nome=$nome&telefone=$telefone&quantidade=$quantidade&tamanho=$tamanho&sabores=$sabores&retirar=$retirar&metodo=$metodo&total=$total&status=$status'>Editar</a></td>
    				
    			</tr>";
    	}
    	?>    
    </table>
    <!-- Link para uma nova pagina de cadastro de aluno. -->
	<br><br>
	<a href="index.php">Me leve de volta</a><br><br>
</body>
</html>