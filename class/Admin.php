<?php
include_once 'Conectar.php';
include_once 'Controles.php';

class Admin
{
    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $dadosJson;
    private $id;
    private $nome;
    private $email;
    private $idade;
    private $con;

    private $caminho;

    private $imagem;

    private $temp_imagem;

    private $control;
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }


    public function getDadosJson()
    {
        return $this->dadosJson;
    }
    public function setDadosJson($dadosJson)
    {
        $this->dadosJson = $dadosJson;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getIdade()
    {
        return $this->idade;
    }
    public function setIdade($idade)
    {
        $this->idade = $idade;
    }
    function salvar()
    {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO admin VALUES (null, ?, ?, ?)";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->idade);




            return $sql->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    // para  mandar imagem para pasta cusos dentro da img


    // as fu




    function consultar()
    {
        try {
            //estabelece conexão com bd
            $this->con = new Conectar();
            //monta a string sql
            $sql = "SELECT * FROM admin";
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
    function consultarPorID()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM admin WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE; // troquei o $ligacao por $sql para não dar error 
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }


    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'admin.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'admin.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }
    function editar()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE  admin SET   nome =?, email = ?, idade = ? WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->email);
            $sql->bindValue(3, $this->idade);
            $sql->bindValue(4, $this->id);


            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }


    function excluir()
    {

        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM admin WHERE id = ?";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);

            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }

    function enviarArquivos()
    {
        $this->control = new Controles();
        return $this->control->enviarArquivo(
            $this->temp_imagem,
            $this->caminho . $this->imagem,
            "Enviar imagem de cursos"
        );

    }
    function consultarLike($letra)
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM admin WHERE nome LIKE ? ORDER BY nome";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $letra . '%');

            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }




}