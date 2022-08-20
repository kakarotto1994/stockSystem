<?php 

require_once '../connection.php';
require_once '../header.php';

if(!isset($_SESSION)) {
    session_start();
}

abstractValidation::validatelogged();

?>

<body>
    <div class="form">
    <form action="salva_produtos.php" method="post">
        <p><label> Status: 
            <select name="status">
                <option value="1" selected>Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </label></p>
        <p><label> Nome do Produto: <input type="text" name="descricao" placeholder="Descricao do produto"> </label></p>
        <p><label> Valor do Produto: <input type="number" name="valor_produto"></label> </p>
        <button type="submit">Salvar</button>
    </form>
    </div>
</body>
</html>