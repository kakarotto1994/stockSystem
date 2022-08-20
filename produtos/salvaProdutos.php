<?php

require_once "../abastractValidation.php";
phpinfo();

if(!isset($_SESSION)) {
    session_start();
}

class salvaProdutos extends abstractValidation  {
    const TABLE_NAME = 'produtos';

    public function __construct() {
        extract($_POST);
        try{
            if(empty($descricao) || empty($valor_produto)) {
                throw new \Exception("Nome do produto ou valor do produto invalidos");
            }
            header('Location: /login.php');
            self::inputData(self::TABLE_NAME, $_POST);
            echo "cadastrado com sucesso";
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

}