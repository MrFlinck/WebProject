<?php
include_once 'Conectar.php';
include_once 'Controles.php';
class Funcionario
{
    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $dadosJson;
    private $id;
    private $nome;
    private $salario;
    private $depto;
    private $temp_imagem;
    private $imagem;
    private $control;
    private $caminho = "../img/funcionario/";
    private $con;

    function getId()
    {
        return $this->id;
    }
    function setId($id)
    {
        $this->id = $id;
    }
    function getNome()
    {
        return $this->nome;
    }
    function setNome($nome)
    {
        $this->nome = $nome;
    }
    function getSalario()
    {
        return $this->salario;
    }
    function setSalario($salario)
    {
        $this->salario = $salario;
    }
    function getDepto()
    {
        return $this->depto;
    }
    function setDepto($depto)
    {
        $this->depto = $depto;
    }
    public function getDadosJson()
    {
        return $this->dadosJson;
    }
    public function setDadosJson($dadosJson)
    {
        $this->dadosJson = $dadosJson;
    }

    function getImagem()
    {
        return $this->imagem;
    }
    function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }
    function getTemp_imagem()
    {
        return $this->temp_imagem;
    }
    function setTemp_imagem($temp_imagem)
    {
        $this->temp_imagem = $temp_imagem;
    }
    function getControl()
    {
        return $this->control;
    }
    function setControl($control)
    {
        $this->control = $control;
    }




    function consultar()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM funcionario";
            $sql = $this->con->prepare($sql); // quando é só a tabela inteira, não precisa de bindvalue 
            return $sql->execute() == 1 ? $sql->fetchAll() : false;

        } catch (PDOException $exc) {
            echo "Erro de bd" . $exc->getMessage();
        }
    }
    function consultarPorId()
    {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM funcionario WHERE id = ?";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id); // agora para consultar por id, é necessario um bindValue 
            return $sql->execute() == 1 ? $sql->fetchAll() : false;

        } catch (PDOException $exc) {
            echo "Erro de bd" . $exc->getMessage();
        }
    }
    /*
    function salvar()
    {
    try {
    $this->con = new Conectar();
    $sql = "INSERT INTO funcionario VALUES (null,?, ?, ?, ?)";
    $sql = $this->con->prepare($sql);
    
    $sql->bindValue(1, $this->nome);
    $sql->bindValue(2, $this->salario);
    $sql->bindValue(3, $this->depto);
    $sql->bindValue(4, $this->imagem);
    
    return $sql->execute() == 1 ? true : false;
    } catch (PDOException $exc) {
    echo "Erro de bd" . $exc->getMessage();
    }
    }
    */
    function editar()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE funcionario SET nome = ?, salario = ?, depto =?, imagem = ?  where id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->salario);
            $sql->bindValue(3, $this->depto);
            $sql->bindValue(4, $this->imagem);
            $sql->bindValue(5, $this->id);
            return $sql->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo "erro de bd" . $exc->getMessage();
        }
    }

    function excluir()
    {
        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM funcionario WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);
            return $sql->execute() == 1 ? true : false;
        } catch (PDOException $exc) {
            echo "erro de bd" . $exc->getMessage();
        }
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
    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'funcionario.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'funcionario.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }
    public function excluirFirebase($key)
    {
        $chave = 'funcionario/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }
    public function editarFirebase($key)
    {
        $chave = 'funcionario/' . $key;
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
        $chave = 'funcionario/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $dados = json_decode($resposta, true);
    }

}