<!DOCTYPE html>
<html lang="en">
<head>    
    <title>Favorita Express</title>
	
	<link rel="stylesheet" href="./styles/pedidos.css">
</head>
<body>
<h2 id="pedidos">PEDIDOS</h2>
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
			<td><b>Endereço</b></td>
			<td><b>Total</b></td>
			<td><b>Status</b></td>
    		<td><b>Editar</b></td>
    		<td><b>Excluir</b></td>
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
			$endereco = $row["endereco"];
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
					<td>$endereco</td>
    				<td>$total</td>
					<td>$status</td>
    				<td><a id='editar' href='formeditarpedido.php?id=$id&nome=$nome&telefone=$telefone&quantidade=$quantidade&tamanho=$tamanho&sabores=$sabores&retirar=$retirar&metodo=$metodo&endereco=$endereco&total=$total&status=$status'>Editar</a></td>
    				<td><a id='excluir' href='excluirpedido.php?id=$id'>Excluir</a></td>
    			</tr>";
    	}
    	?>    
    </table>
    <!-- Link para uma nova pagina de cadastro de aluno. -->
    <a id="link3" href="cadastropedido.php">Novo Pedido</a> <br><br>
	<a id="link" href="paineladmin.php"><p id="text">Me leve de volta</p></a><br><br>
</body>
</html>