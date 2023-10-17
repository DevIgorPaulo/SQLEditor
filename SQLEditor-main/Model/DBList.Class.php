<?php
include_once 'Conexao.Class.php';

class DBList extends Conexao{
    public $tables;
    public $views;
    public $functions;
    public $procedures;
    public $columns;

    function __construct()
    {
        
    }

    public function listaDBModel($db)
    {
        if($db){
            $this->tables = $this->listaTables($db);
            $this->views = $this->listaViews($db);
            $this->functions = $this->listaFunctions($db);
            $this->procedures = $this->listaProcedures($db);
        }
    }

    private function listaTables($db){
        try {
            $retorno = $this->executarQuery("USE '$db'; SHOW TABLES;");
        } catch (\Throwable $th) {
            $retorno = $th->getMessage();
        }
        return $retorno;
    }

    private function listaViews($db){
        try {
            $retorno = $this->executarQuery("SELECT TABLE_NAME
            FROM information_schema.VIEWS
            WHERE TABLE_SCHEMA = '$db';");
        } catch (\Throwable $th) {
            $retorno = $th->getMessage();
        }
        return $retorno;
    }

    private function listaFunctions($db){
        try {
            $retorno = $this->executarQuery("SELECT TABLE_NAME
            FROM information_schema.VIEWS
            WHERE TABLE_SCHEMA = '$db';");
        } catch (\Throwable $th) {
            $retorno = $th->getMessage();
        }
        return $retorno;
    }

    private function listaProcedures($db){
        try {
            $retorno = $this->executarQuery("SELECT ROUTINE_NAME
                FROM information_schema.ROUTINES
                WHERE ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_SCHEMA = '$db';
            ");
        } catch (\Throwable $th) {
            $retorno = $th->getMessage();
        }
        return $retorno;
    }

    private function listaColumns($table){
        try {
            $retorno = $this->executarQuery("SHOW COLUMNS FROM '$table';");
        } catch (\Throwable $th) {
            $retorno = $th->getMessage();
        }
        return $retorno;
    }
}