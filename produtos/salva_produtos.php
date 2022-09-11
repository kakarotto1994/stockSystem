<?php 

require_once "salvaProdutos.php";

try {
    $_POST['descricao'] = "'".$_POST['descricao']."'";
    var_dump($_POST['descricao']);
    $response = new salvaProdutos($_POST);
    echo 'Cadastrado com sucesso';
    sleep(1);
    header('Location: /login.php');
} catch (\Exception $e) { 
    echo $e;
}

?>