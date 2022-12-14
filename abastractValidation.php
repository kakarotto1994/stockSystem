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

    /**
     * Busca todo os itens atraves do nome da tabela e o algumas colunas
    */
    public function findByColumn($table, $where, $limit = null) 
    {
        try{ 
            $mysqli = $this->mysqli;
            
            $query = "SELECT * FROM $table where 1 = 1 ";
            $query .= $where;
            $query .= " group by id ";
            if(!empty($limit)) {
                $query .= " limit ". implode(',', $limit);
            }
            $responseQuery = $mysqli->query($query) or die("ERRO: ".$mysqli->error);
            $response = [];
            while($response[] = $responseQuery->fetch_assoc()){

            }
            return $response;
        } catch (\Exception $e) {
            throw $e->getMessage();
        }
    }

    public function findCount($table) 
    {
        try{ 
            $mysqli = $this->mysqli;
            
            $query = "SELECT count(id) as total FROM $table where 1 = 1 ";
            $responseQuery = $mysqli->query($query) or die("ERRO: ".$mysqli->error);

            return $responseQuery->fetch_assoc();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getPagination($table) 
    {
        return $this->findCount($table);
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
            foreach ($data as $nameColumn => $column){
                if(is_null($column) || $column == ''){
                    unset($data[$nameColumn]);
                }
            }
            $query = "INSERT IGNORE INTO $table (".implode(',', array_keys($data)).") VALUES (".implode(',', $data)." )";
            $columns = $this->getColumns($table);
            // var_dump($columns);
            // $dataValues = [];
            // foreach($data as $nameColumn => $value) {
            //     foreach($columns as $column) {  
            //         var_dump('OPA', $column["COLUMN_NAME"], 'coluna query', $nameColumn);
            //         if($nameColumn == $column["COLUMN_NAME"]) {
            //             $dataValues[] = $value;
            //             break;
            //         }
            //     }
            // }

            // $query .= implode(",", $dataValues).");";
            $mysqli->query($query) or die("ERRO: ".$mysqli->error);
        } catch (\Exception $e) {
            throw $e->getMessage();
        }
    }

    protected function updateData ($table, Array $data) 
    {
        $mysqli = $this->mysqli;
        $id = $data['id'];
        unset($data['id']);
        $query = "UPDATE $table set ";
        $setValues= [];
        foreach($data as $key => $value) {
            if(is_null($value) || $value == ''){
                continue;
            }
            $setValues[] = "$key = $value ";
        }

        $where = " where id = $id";
        $query.= implode(',',$setValues).$where;
        $mysqli->query($query) or die("ERRO: ".$mysqli->error."<br>".$query);
    }

    protected function getColumns($table) 
    {
        $query = "SELECT COLUMN_NAME from information_schema.columns
        where TABLE_NAME = '$table' limit 2000; ";
        $mysqli = $this->mysqli;
        $responses = $mysqli->query($query) or die("ERRO: ".$mysqli->error);

        if($responses->num_rows > 0) {
            $fullResponse = [];
            while($fullResponse[] = $responses->fetch_assoc()) {
            }
            return $fullResponse;
        } else {
            throw new Exception(" Dados não encontrados na table $table ");
        }
    }

}

?>