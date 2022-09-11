<?php

require_once '../connection.php';
require_once '../header.php';

const TABLE_NAME = 'produtos';


if(!isset($_SESSION)) {
    session_start();
}

try {
    // verifica a pagina
    $pag_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pag_atual)) ? $pag_atual : 1;
    $limitByPage = 20;

    // inicio da visualização
    $inicio = ($limitByPage * $pagina) - $limitByPage;

    $limit = [$inicio , $limitByPage];

    abstractValidation::validatelogged();
    $abstractValidation = new abstractValidation();
    $where = '';
    extract($_GET);
    if(!empty($ean) || !empty($descricao)) {
        if(!empty($ean)) {
            $where .= " AND ean rlike '$ean' ";
        }
        if(!empty($descricao)) {
            $where .= " AND descricao rlike '$descricao' ";
        }
    } 

    $produtos = $abstractValidation->findByColumn(TABLE_NAME, $where, $limit);


} catch (\Exception $e) {
    echo $e;
}
?>

<body>
    <div name="body">
    <div class="form">
        <form action="visualiza_produtos.php" method="get">
           <p><label> Nome do Produto: <input type="text" name="descricao" placeholder="Descricao do produto"> </label></p>
           <p><label> Codigo de Barras: <input type="text" name="ean" placeholder="Codigo de Barras"> </label></p>
           <button type="submit">buscar</button>
           <button type='submit' formmethod='GET' formaction='editar_produto.php' >Criar</button> <br>

           <br> <div name="table">
            <table border="1">
                <tr>
                    <th> Nome Produto</th>
                    <th> Codigo de Barras</th>
                    <th> Editar</th>
                </tr>
                <?php foreach($produtos as $produto) {
                    @extract($produto);
                    echo "<tr><td >$descricao</td>";
                    echo "<td>$ean</td>";
                    echo "<td><button type='submit' name='id' value=$id formmethod='GET' formaction='editar_produto.php' >Editar</button></td></tr>";
                } 
                ?>
            </table>
        </div>
        </form>
    </div>
    </div>
</body>
<div name="pagination">
    <?php 
        $qtd_total = $abstractValidation->getPagination(TABLE_NAME);

        // Qtd paginas
        $qtd_pg = ceil($qtd_total['total'] / $limitByPage);
    
        // limitar liks antes e depois
        $max_links = 2;
    
        echo "<a href='visualiza_produtos.php?pagina=1'>Primeira </a>";
    
        // Paginas antes das atuais
        for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if($pag_ant > 0) {
                echo "<a href='visualiza_produtos.php?pagina=$pag_ant'>$pag_ant </a>";
            }
        }
    
        // pagina atual
        echo $pagina;
    
        // Paginas após as atuais
        for($pag_pos = $pagina + 1; $pag_pos <= $pagina + $max_links; $pag_pos++) {
            if($pag_pos <= $qtd_pg) {
                echo "<a href='visualiza_produtos.php?pagina=$pag_pos'> $pag_pos</a>";
            }
        }
    
        echo "<a href='visualiza_produtos.php?pagina=$qtd_pg'> ULTIMA</a>";
    ?>
</div>
</html>