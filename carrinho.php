<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Faça Seu Pedido</title>
    <link rel="stylesheet" href="./styles/carrinho.css">
    <script>
        function atualizarSabores() {
            var tamanho = document.getElementById('tamanho').value;
            var saboresContainer = document.getElementById('sabores');
            var preco = document.getElementById('preco');
            var total = document.getElementById('total');
            var precoPizza = {
                pequeno: 35,
                médio: 45,
                grande: 55,
                gigante: 75
            };
            
            var quantidadeSabores = {
                pequeno: 1,
                médio: 3,
                grande: 4,
                gigante: 4
            };

            var numSabores = quantidadeSabores[tamanho] || 1;
            saboresContainer.innerHTML = '';
            for (var i = 0; i < numSabores; i++) {
                var select = document.createElement('select');
                select.name = 'sabor[]';
                select.innerHTML = '<option value="mussarela">Mussarela</option><option value="calabresa">Calabresa</option><option value="portuguesa">Portuguesa</option>';
                saboresContainer.appendChild(select);
            }

            var precoAtual = precoPizza[tamanho] || 0;
            preco.textContent = `R$ ${precoAtual},00`;
            total.textContent = `${precoAtual},00`;
        }

        function toggleBebidas() {
            var bebidasContainer = document.getElementById('opcoes-bebidas');
            var temBebida = document.getElementById('tem-bebida').checked;
            bebidasContainer.style.display = temBebida ? 'block' : 'none';
            atualizarTotal();
        }

        function atualizarTotal() {
            var tamanho = document.getElementById('tamanho').value;
            var precoPizza = {
                pequeno: 35,
                médio: 45,
                grande: 55,
                gigante: 75
            };
            
            var total = precoPizza[tamanho] || 0;
            var checkboxes = document.querySelectorAll('#opcoes-bebidas input[type="checkbox"]:checked');
            var precoBebidas = {
                'coca-cola': 7,
                'pepsi': 5,
                'agua': 4,
                'guarana': 6
            };
            checkboxes.forEach(function(checkbox) {
                total += precoBebidas[checkbox.value] || 0;
            });

            document.getElementById('total').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }
    </script>
</head>
<body>
    <h1>Faça Seu Pedido</h1>

    <form action="adicionar_ao_carrinho.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Tamanho</th>
                    <th>Sabor</th>
                    <th>Bebida</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pizza Margherita</td>
                    <td>
                        <select name="tamanho" id="tamanho" onchange="atualizarSabores()">
                            <option value="pequeno">Pequeno</option>
                            <option value="médio">Médio</option>
                            <option value="grande">Grande</option>
                            <option value="gigante">Gigante</option>
                        </select>
                    </td>
                    <td id="sabores">
                        <select name="sabor[]">
                            <option value="mussarela">Mussarela</option>
                            <option value="calabresa">Calabresa</option>
                            <option value="portuguesa">Portuguesa</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" id="tem-bebida" name="tem_bebida" onchange="toggleBebidas()">
                        <label for="tem-bebida">Adicionar Bebida</label>
                    </td>
                    <td><input type="number" name="quantidade" value="1" min="1"></td>
                    <td id="preco">R$ 30,00</td>
                </tr>
            </tbody>
        </table>

        <div id="opcoes-bebidas" style="display: none;">
            <h2>Escolha suas bebidas:</h2>
            <div class="bebida">
                <input type="checkbox" id="coca-cola" name="bebida[]" value="coca-cola">
                <label for="coca-cola">Coca-Cola (R$ 7,00)</label>
            </div>
            <div class="bebida">
                <input type="checkbox" id="pepsi" name="bebida[]" value="pepsi">
                <label for="pepsi">Pepsi (R$ 5,00)</label>
            </div>
            <div class="bebida">
                <input type="checkbox" id="agua" name="bebida[]" value="agua">
                <label for="agua">Água (R$ 4,00)</label>
            </div>
            <div class="bebida">
                <input type="checkbox" id="guarana" name="bebida[]" value="guarana">
                <label for="guarana">Guaraná (R$ 6,00)</label>
            </div>
        </div>

        <p>Total: R$ <span id="total">30,00</span></p>
        <input type="submit" value="Adicionar ao Carrinho">
    </form>
</body>
</html>
