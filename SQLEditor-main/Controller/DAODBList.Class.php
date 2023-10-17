<?php
include_once '../Model/DBList.Class.php';

class DAODBList extends DBList{

    public $retorno;

    function __construct()
    {

    }

    function listaDBController($db){
        $this->listaDBModel($db);
        return array(
            'Tables' => $this->tables,
            'View' => $this->views,
            'Functions' => $this->functions,
            'Procedures' => $this->procedures,
        );        
    } 

}
if($_REQUEST['funcao']){
    $fn = $_REQUEST['funcao'];
    $ObjDAODBList = new DAODBList();
    
    if (isset($_REQUEST['funcao']) && method_exists($ObjDAODBList, $_REQUEST['funcao'])) {
  
        $funcao = $_REQUEST['funcao'];
        $ObjDAODBList->$funcao(file_get_contents("php://input"));
        
        echo json_encode($ObjDAODBList->retorno);
    } else {
        echo "Função não encontrada ou não permitida.";
    }
   
}