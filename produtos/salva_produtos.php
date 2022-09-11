<?php 

require_once "salvaProdutos.php";

try {
    $_POST['descricao'] = "'".$_POST['descricao']."'";
    $response = new salvaProdutos($_POST);
    echo 'Cadastrado com sucesso';
    sleep(1);
    header('Location: visualiza_produtos.php');
} catch (\Exception $e) { 
    echo $e;
}

?>