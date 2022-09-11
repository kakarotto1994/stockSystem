<?php 

require_once '../connection.php';
require_once '../header.php';

const TABLE_NAME = 'produtos';

$produtos = '';

if(!isset($_SESSION)) {
    session_start();
}
try {
    
    abstractValidation::validatelogged();

    $abstractValidation = new abstractValidation();

    if(!empty($_GET['id'])) {
        echo "oi";
        $produtos = $abstractValidation->find(TABLE_NAME, $_GET['id']);
        extract($produtos);
        echo "<h2> Atualizar Produto </h2>";
        var_dump( $status);
    } else {
        echo "<h2> Criar Produto </h2>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

<body>
    <div class="form">
    <form action="salva_produtos.php" method="post">
        <p><label> Status: 
            <select name="status">
                <?php if(!isset($status)) {$status = 1;} echo abstractValidation::generateSelectStatus($status)?>
            </select>
        </label></p>
        <p><label> Nome do Produto: <input type="text" name="descricao" <?php if(!empty($descricao)) {echo "value=$descricao";} ?> placeholder="Descricao do produto"> </label></p>
        <p><label> Valor do Produto: R$ <input type="number" min="1" step=".01" name="valor_produto" <?php if(!empty($valor_produto)) {echo "value=$valor_produto";} ?>></label> </p>
        <p><label> Cod de Barras: <input type="number" name="ean" <?php if(!empty($ean)) {echo "value=$ean";} ?>></label> </p>
        <input type="hidden" name="id" <?php if(isset($id)) {echo "value=$id";}?>>
        <button type="submit">Salvar</button>
    </form>
    </div>
</body>
</html>