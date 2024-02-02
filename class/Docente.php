<?php

include_once 'Conectar.php';

class Docente{
    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $dadosJson;
    private $id;
    private $nome;
    private $email;
    private $formacao; 
 

    
    
    private $con;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

   

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getFormacao(){
        return $this->formacao;
    }
    public function setFormacao($formacao){
        $this->formacao = $formacao;
    }
    public function getDadosJson(){
        return $this->dadosJson;
    }
    public function setDadosJson($dadosJson){
        $this->dadosJson = $dadosJson;
    }

  

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO docente VALUES (null, ?, ?, ?)";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->formacao);


   

            return $sql->execute() == 1 ? true : false;
        }   catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function consultar() {
        try {
            //estabelece conexão com bd
            $this->con = new Conectar();
            //monta a string sql
            $sql = "SELECT * FROM docente";
            //faz a ligação entre a conexão com a string sql
            $ligacao = $this->con->prepare($sql);

            return $ligacao->execute() == 1 ? $ligacao->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

    function consultarPorID() {
        try {  
            $this->con = new Conectar();
            $sql = "SELECT * FROM docente WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
            $sql = $this->con->prepare($sql);  
            $sql->bindValue(1, $this->id); 
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE; // troquei o $ligacao por $sql para não dar error 
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }


  

    function editar() { 
        try {
            $this->con = new Conectar();
            $sql = "UPDATE  docente SET nome = ?, email = ?, formacao = ?  WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->formacao);
            $sql->bindValue(4, $this->id);
            

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function excluir(){
         try {
            $this->con = new Conectar();
            $sql = "DELETE FROM docente WHERE id = ?";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    function consultarLike($letra) {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM docente WHERE nome LIKE ? ORDER BY nome";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $letra . '%'); // trocar de nome não mudou nada 
 
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'docente.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'docente.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }

   
}



