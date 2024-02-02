<?php

include_once 'Conectar.php';

class Area{

    private $id;
    private $nome;
    
    
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

  

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO area VALUES (null, ?)";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);

   

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
            $sql = "SELECT * FROM area";
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
            $sql = "SELECT * FROM area WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
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
            $sql = "UPDATE  area SET nome = ?  WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->id);
            

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    function excluir(){
         try {
            $this->con = new Conectar();
            $sql = "DELETE FROM area WHERE id = ?";
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
            $sql = "SELECT * FROM area WHERE area LIKE ? ORDER BY area";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $letra . '%'); // trocar de nome não mudou nada 
 
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

   
}



