<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class Categoria
{

    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $id; # as propriedades do class categoria 
    private $descricao;
    private $ramal;
    private $area;
    private $con;
    private $control;
    private $temp_imagem;
    private $imagem;
    private $caminho = "../img/categoria/";

    private $dadosJson;

    public function getDadosJson()
    {
        return $this->dadosJson;
    }

    public function setDadosJson($dadosJson)
    {
        $this->dadosJson = $dadosJson;
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
    // as funções do class 
    function getRamal()
    {
        return $this->ramal; #retornar $this para ter acesso aos dados 
    }

    function setRamal($ramal)
    {
        $this->ramal = $ramal;
    }

    function getId()
    {
        return $this->id;
    }

    function getDescricao()
    {
        return $this->descricao;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    function getControl()
    {
        return $this->control;
    }
    function setControl($control)
    {
        $this->control = $control;
    }

    function getArea()
    {
        return $this->area;
    }

    function setArea($area)
    {
        $this->area = $area;
    }
  
    function consultar()
    {
    try {
    //estabelece conexão com bd
    $this->con = new Conectar();
    //monta a string sql
    $sql = "SELECT * FROM categoria";
    //faz a ligação entre a conexão com a string sql
    $ligacao = $this->con->prepare($sql);
    return $ligacao->execute() == 1 ? $ligacao->fetchAll() : FALSE;
    } catch (PDOException $exc) {
    echo "Erro de bd " . $exc->getMessage();
    }
    }
    function consultarPorID()
    {
    try {
    $this->con = new Conectar();
    $sql = "SELECT * FROM categoria WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
    $sql = $this->con->prepare($sql);
    $sql->bindValue(1, $this->id);
    return $sql->execute() == 1 ? $sql->fetchAll() : FALSE; // troquei o $ligacao por $sql para não dar error 
    } catch (PDOException $exc) {
    echo "Erro de bd " . $exc->getMessage();
    }
    }
   
    
    /*
    function salvar()
    {
    try {
    $this->con = new Conectar();
    $sql = "INSERT INTO categoria VALUES (null, ?, ?, ?, ? )";
    $sql = $this->con->prepare($sql);
    $sql->bindValue(1, $this->descricao);
    $sql->bindValue(2, $this->ramal);
    $sql->bindValue(3, $this->imagem);
    $sql->bindValue(4, $this->area);
    return $sql->execute() == 1 ? TRUE : FALSE;
    } catch (PDOException $exc) {
    echo "Erro de bd " . $exc->getMessage();
    }
    }
    */
    function salvar($tipo) {
        try {
            $this->con = new Conectar();
            if ($tipo == 'insert') {
                $exec = $this->con->prepare("INSERT INTO categoria VALUES (null, ?, ?, ?, ?)");
                $exec->bindValue(1,$this->descricao);
                $exec->bindValue(2,$this->ramal);
                $exec->bindValue(3,$this->imagem);
                $exec->bindValue(4,$this->area);
            } else if ($tipo == 'update') {
                $exec = $this->con->prepare("UPDATE categoria SET descricao = ?, ramal = ?,  imagem = ?, area = ?   WHERE id = ?");
                $exec->bindValue(1,$this -> descricao);
                $exec->bindValue(2,$this -> ramal);
                $exec->bindValue(3,$this->imagem);
                $exec->bindValue(4,$this->area);
                $exec->bindValue(5, $this->id);
            }

            $exec->bindValue(1, $this->descricao);
            $exec->bindValue(2, $this->ramal);

            return $exec->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    
    


    public function excluirArquivos() {
        $this->control = new Controles();
        return $this->control->excluirArquivo($this->caminho . $this->imagem, $this->descricao);
    }
    function enviarArquivos()
    {
        $this->control = new Controles();
        return $this->control->enviarArquivo(
            $this->temp_imagem,
            $this->caminho . $this->imagem,
            "Enviar imagem de categoria"
        );

    }
    function editarImagem() {
        try {
            $this->con = new Conectar();
            $exec = $this->con->prepare("UPDATE categoria SET imagem = ? WHERE id = ?");
            $exec->bindValue(1, $this->imagem);
            $exec->bindValue(2, $this->id);

            return $exec->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'categoria.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'categoria.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }
    

    public function excluirFirebase($key)
    {
        $chave = 'categoria/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }
    public function editarFirebase($key)
    {
        $chave = 'categoria/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }


    public function consultarPorIDFirebase($key)
    {
        $chave = 'categoria/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $dados = json_decode($resposta, true);
    }

    
    /*
    function editar()
{
try {
$this->con = new Conectar();
$sql = "UPDATE  categoria SET descricao = ?, ramal= ?,imagem = ?  WHERE id = ? ";
$sql = $this->con->prepare($sql);
$sql->bindValue(1, $this->descricao);
$sql->bindValue(2, $this->ramal);
$sql->bindValue(3, $this->imagem);
$sql->bindValue(4, $this->id);
return $sql->execute() == 1 ? TRUE : FALSE;
} catch (PDOException $exc) {
echo "Erro de bd " . $exc->getMessage();
}
}
*/

function excluir()
{
try {
$this->con = new Conectar();
$sql = "DELETE FROM categoria WHERE id = ?";
$sql = $this->con->prepare($sql);
$sql->bindValue(1, $this->id);
return $sql->execute() == 1 ? TRUE : FALSE;
} catch (PDOException $exc) {
echo "Erro de bd " . $exc->getMessage();
}
}

function consultarLike($letra)
{
try {
$this->con = new Conectar();
$sql = "SELECT * FROM categoria WHERE descricao LIKE ? ORDER BY descricao";
$sql = $this->con->prepare($sql);
$sql->bindValue(1, $letra . '%'); // trocar de nome não mudou nada 
return $sql->execute() == 1 ? $sql->fetchAll() : FALSE;
} catch (PDOException $exc) {
echo "Erro de bd " . $exc->getMessage();
}
}



}