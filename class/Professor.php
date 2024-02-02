<?php

include_once 'Conectar.php';

class Professor {

    private $id;
    private $descricao;
    private $ramal;
    private $con;
        private $control;
    private $temp_imagem;
    private $imagem;
    private $caminho = "../img/professor/";

    function getId(){
        return $this ->id; 
    }
    function setId($id){
        $this -> id = $id; 
    }

    function getNome(){
        return $this -> nome;
    }
    function setNome($nome){
        $this -> nome = $nome;
    }

    function getEmail(){
        return $this -> email;
    }
    function setEmail($email){
        $this -> email = $email;
    }

    function getArea(){
        return $this -> area;
    }
    function setArea($area){
        $this -> area = $area;
    } 
    
    function getTemp_imagem()
    {
        return $this->temp_imagem;
    }
    function setTemp_imagem($temp_imagem)
    {
        $this->temp_imagem = $temp_imagem;
    }
    function getImagem()
    {
        return $this->imagem;
    }
    function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    function consultar() {
        try {
            //estabelece conexão com bd
            $this->con = new Conectar();
            //monta a string sql
            $sql = "SELECT * FROM professor";
            //faz a ligação entre a conexão com a string sql
            $ligacao = $this->con->prepare($sql);
            /*
             * faz um if ternário que verifica se a consulta foi executada == 1
             * se sim, retorna todos os registros da tabela fetchAll()
             * se não, retorna false
             */
            return $ligacao->execute() == 1 ? $ligacao->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

    function consultarPorID() {
        try {  
            $this->con = new Conectar();
            $sql = "SELECT * FROM professor WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
            $sql = $this->con->prepare($sql);  
            $sql->bindValue(1, $this->id); 
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE; // troquei o $ligacao por $sql para não dar error 
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
  


    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO professor VALUES (null, ?, ?,?,? )";
            $sql = $this->con->prepare($sql);
  
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->area);
            $sql->bindValue(4,$this-> imagem);

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function editar() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE  professor SET nome = ?, email= ?, area = ? WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->area);
            $sql->bindValue(4,$this->imagem);
            $sql->bindValue(5, $this->id);
            

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function excluir(){
         try {
            $this->con = new Conectar();
            $sql = "DELETE FROM professor WHERE id = ?";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

   
}
 