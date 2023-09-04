<?php
include_once '../Model/EditorSQL.Class.php';

Class DAOEditorSQL extends EditorSQL{
    
    public $retorno;

    function __construct(){
        parent::__construct();
    }

    function executaQueryController($sql){
        if($sql){
            $this->retorno = $this->executaQueryModel($sql);
        }else{
            $this->retorno->dados = "Nenhuma SQL inserida!";
            $this->retorno->sucesso = false;
        }

        return $this->retorno;
    }
}
if($_REQUEST['funcao']){
    $fn = $_REQUEST['funcao'];
    $ObjDAOEditorSQL = new DAOEditorSQL();
    
    if (isset($_REQUEST['funcao']) && method_exists($ObjDAOEditorSQL, $_REQUEST['funcao'])) {
  
        $funcao = $_REQUEST['funcao'];
        $ObjDAOEditorSQL->$funcao(file_get_contents("php://input"));
        
        echo json_encode($ObjDAOEditorSQL->retorno);
    } else {
        echo "Função não encontrada ou não permitida.";
    }
   
}