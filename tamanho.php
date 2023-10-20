<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/tamanho.css">
    <link rel="stylesheet" href="./styles/precos.css">

    <title> Favorita Express</title>
</head> 

<body>
    <header>
    <div id="menutexto">
        <p>Escolha o tamanho</p>
    </div>
    <div id="menudireito">
        <a href="cardapio.php" id="inscreva-se-btn"><li id="text">Escolha o Sabor</li></a>
    </div>
    <div id="menuesquerdo">
        <a href="index.php" id="inscreva-se-btnn"><li id="text">Voltar</li></a>
    </div>
    </header>   

    <h2 id="texto"></h2>

    <div id="tamanho1">
        <div id="pizza"></div>
        <p id=tamanho8>PEQUENA</p>
        <p id="pedacos4">4 pedaços</p>  
    </div>

    <div id="tamanho2">
        <div id="pizza"></div>
        <p id=tamanho7>MÉDIA</p>
        <p id="pedacos3">6 pedaços</p>  
    </div>

    <div id="tamanho3">
        <div id="pizza"></div>
        <p id=tamanho6>GRANDE</p>
        <p id="pedacos2">8 pedaços</p>  
    </div>

    <div id="tamanho4">
        <div id="pizza"></div>  
        <p id=tamanho5>GIGANTE</p>
        <p id="pedacos1">12 pedaços</p>  
    </div>
    <div id="sifrao1">
        <p>R$</p> 
    </div>
    <div id="sifrao2">
        <p>R$</p> 
    </div>
    <div id="sifrao3">
        <p>R$</p> 
    </div>
    <div id="sifrao4">
        <p>R$</p> 
    </div>


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
    		
            $preco = str_replace('.', ',', $preco);

    		//imprime na página uma nova linha dentro da tabela com os dados do aluno e um link para excluir o aluno passando o ID por parametro via GET.
    		echo "<tr>

    				<td>$preco</td>
    				
    			</tr>";

    	}
        ?>  
    </table>

</body>
</html>