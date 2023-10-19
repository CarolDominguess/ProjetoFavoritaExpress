<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/localizacao.css">
    <title>Document</title>
</head>
<body>
    kjbkjbsd
</body>
</html>
<table border='0'>
    	
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
	
    				<td>$preco</td>
    				
    			</tr>";
    	}
?>  
    </table>