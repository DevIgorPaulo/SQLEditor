<?php
class Conexao {
    private $host = "127.0.0.1";
    private $db_name = "escola";
    private $username = "root";
    private $password = "";
    private $conexao;
    private $retorno;

    public function __construct()
    {
        $this->retorno = new stdClass();
    }

    public function conectar() {
        $this->conexao = null;
        
        try {
            $this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
           
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }

        return $this->conexao;
    }

    public function fecharConexao() {
        $this->conexao = null;
    }

    public function executarQuery($query, $params = []) {
        try {
            $this->conectar();
            
            if ($this->conexao) {
                $stmt = $this->conexao->prepare($query);
                
                $stmt->execute($params);
                $this->retorno->dados = $stmt->fetchAll();
                $this->retorno->sucesso = true;
                
            } else {
                $this->retorno->dados = "Não foi possível conectar ao banco de dados.";
                $this->retorno->sucesso = false; 
            }
        } catch(PDOException $e) {
            $this->retorno->dados = "Erro na execução da query: " . $e->getMessage();
            $this->retorno->sucesso = false;
            
        }
        return $this->retorno;
    }
}
