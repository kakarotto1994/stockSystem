<?php

session_start();

class abstractValidation  {

    public $db;
    public $mysqli;

    public function __construct()
    {
        $this->db = require 'connection.php';
        extract($this->db);
        $this->mysqli = new mysqli($host, $user, $pass, $db);
        $mysqli = $this->mysqli;
        if($mysqli->connect_errno) {
            die("ERRO $mysqli->connect_errno, $mysqli->connect_error");
        }
    }
   
    /**
     * Verifica se está logado
     */
    public static function validatelogged() {
        if( !isset($_SESSION['logado']) ){
            header('Location: /login.php');
        }
    }

    /**
     * Busca todo os itens por ID atraves do nome da tabela e o id
     */
    public function find($table, $id) 
    {
        try{ 
            $mysqli = $this->mysqli;
            
            $query = "SELECT * FROM $table where id = $id;";
            $response = $mysqli->query($query) or die("ERRO: ".$mysqli->error);

            if($response->num_rows > 0) {
                $response = $response->fetch_assoc();
                return $response;
            } else {
                throw new Exception(" Dados não encontrados na table $table ");
            }
        } catch (Exception $e){
            echo $e->getMessage();
            return $e->getMessage();
        }
    } 

    public static function generateSelectStatus($status = 1,Array $dataStatus = [1,0]) {
        $option = "";
        foreach ($dataStatus as $data) {
            $option .= "<option value=$data";
            if($status == $data) {
                $option .= " selected";
            }
            if($data == 1) {
                $option .= ">Ativo</option>";
            } else {
                $option .= ">Inativo</option>";
            }
        }
        return $option;
    }

    public function inputData ($table, Array $data) 
    {
        if(empty($data['id'])) {
            unset($data['id']);
            $this->insertData($table, $data);
        } else {
            $this->updateData($table, $data);
        }
    }

    protected function insertData ($table, Array $data) 
    {
        try{
            $mysqli = $this->mysqli;
            $query = "INSERT IGNORE INTO $table (".implode(',', $data).") VALUES (";
            $columns = $this->getColumns($table);
            $dataValues = [];
            foreach($data as $nameColumn => $value) {
                foreach($columns as $column) {
                    if($nameColumn == $column) {
                        $dataValues[] = $value;
                        break;
                    }
                }
            }

            $query .= implode(",", $dataValues).");";
            $mysqli->query($query) or die("ERRO: ".$mysqli->error);
        } catch (\Exception $e) {
            throw $e->getMessage();
        }
    }

    protected function updateData ($table, Array $data) {

    }

    protected function getColumns($table) {
        $query = "SELECT COLUMN_NAME from information_schema.columns
        where TABLE_NAME = $table";
        $mysqli = $this->mysqli;
        $response = $mysqli->query($query) or die("ERRO: ".$mysqli->error);

        if($response->num_rows > 0) {
            $response = $response->fetch_assoc();
            return $response;
        } else {
            throw new Exception(" Dados não encontrados na table $table ");
        }
    }

}

?>