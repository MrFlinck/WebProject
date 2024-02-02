<?php

include_once 'Conectar.php';

class Produto {

    private $id;
    private $nome;
    private $id_categoria;
    private $con;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getId_categoria() {
        return $this->id_categoria;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setId_categoria($id_categoria) {
        $this->id_categoria = $id_categoria;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO produto VALUES (null, ?, ?)";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->id_categoria);

            return $sql->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

}
