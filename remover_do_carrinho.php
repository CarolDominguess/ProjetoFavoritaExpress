<?php
session_start();

// Verifica se o carrinho está inicializado
if (isset($_SESSION['carrinho'])) {
    // Verifica se o índice para remoção está definido
    if (isset($_POST['index']) && is_numeric($_POST['index'])) {
        $index = intval($_POST['index']);
        
        // Remove o item do carrinho
        if (isset($_SESSION['carrinho'][$index])) {
            unset($_SESSION['carrinho'][$index]);
            
            // Re-indexa o array do carrinho
            $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
        }
    }
}

// Redireciona de volta para a página de visualizar carrinho
header('Location: visualizar_carrinho.php');
exit;
?>
