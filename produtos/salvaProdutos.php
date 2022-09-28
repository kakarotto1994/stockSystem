<?php

require_once "../abastractValidation.php";
// phpinfo();

if(!isset($_SESSION)) {
    session_start();
}

class salvaProdutos extends abstractValidation  {
    const TABLE_NAME = 'produtos';

    public function __construct($data) {
        parent::__construct();
        extract($data);
        try{
            if(empty($descricao) || empty($valor_produto)) {
                throw new \Exception("Nome do produto ou valor do produto invalidos");
            }
            $this->inputData(self::TABLE_NAME, $data);
            return "cadastrado com sucesso";
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

}