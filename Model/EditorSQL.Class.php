<?php
include_once '../Model/Conexao.Class.php';
Class EditorSQL extends Conexao{

    private $retorno;

    function __construct(){
        parent::__construct();
    }

    function executaQueryModel($query){
        try {
            $this->retorno = $this->executarQuery($query);
            
        } catch (\Throwable $th) {
            $this->retorno->dados = $th->getMessage();
            $this->retorno->sucesso = false;
        }
      
        return $this->retorno;
    }
}