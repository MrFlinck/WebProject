<?php
include_once 'Conectar.php';
include_once 'Controles.php';

class Curso
{
    private $id;
    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $nome;
    private $duracao;
    private $id_area; 
    private $con;
    private $control;
    private $temp_imagem;
    private $imagem;
    private $dadosJson;
    private $caminho = "../img/cursos/"; // para  mandar imagem para pasta cusos dentro da img

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
    // as fu
    public function getId_area() {
        return $this->id_area;
    }
    public function setId_area($id_area) {
        $this->id_area = $id_area;
    }

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
    function getDuracao()
    {
        return $this->duracao;
    }
    function setDuracao($duracao)
    {
        $this->duracao = $duracao;
    }
    
    public function getDadosJson(){
        return $this->dadosJson;
    }
    public function setDadosJson($dadosJson){
        $this->dadosJson = $dadosJson;
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
            //estabelece conexão com bd
            $this->con = new Conectar();
            //monta a string sql
            $sql = "SELECT * FROM cursos";
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
            $sql = "SELECT * FROM cursos WHERE id = ? "; // interrogação significa que precisa encontrar um parametro que é o id
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->id);
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE; // troquei o $ligacao por $sql para não dar error 
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'curso.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'curso.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }
    /*

    function salvar()
    {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO cursos VALUES (null, ?, ?, ?,?)";
            $sql = $this->con->prepare($sql);

            $sql->bindValue(1, $this->nome);
            $sql->bindValue(2, $this->duracao);
            $sql->bindValue(3, $this->imagem);
            $sql->bindValue(4, $this->id_area);


            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    function editar()
    {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE  cursos SET  duracao= ?, nome =?, imagem = ?, id_area = ? WHERE id = ? ";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $this->duracao);
            $sql->bindValue(2, $this->nome);
            $sql->bindValue(3, $this->imagem);
            $sql->bindValue(4, $this->id_area);

            $sql->bindValue(5, $this->id);


            return $sql->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }*/
    function salvar($tipo) {
        try {
            $this->con = new Conectar();
            if ($tipo == 'insert') {
                $exec = $this->con->prepare("INSERT INTO cursos VALUES (null, ?, ?, ?, ?)");
                $exec->bindValue(1,$this->nome);
                $exec->bindValue(2,$this->duracao);
                $exec->bindValue(3,$this->imagem);
                $exec->bindValue(4,$this->id_area);
            } else if ($tipo == 'update') {
                $exec = $this->con->prepare("UPDATE cursos SET nome = ?, duracao = ?, imagem = ? , id_area = ?   WHERE id = ?");
                $exec->bindValue(1,$this->nome);
                $exec->bindValue(2,$this->duracao);
                $exec->bindValue(3,$this->imagem);
                $exec->bindValue(4,$this->id_area);
                $exec->bindValue(5, $this->id);
            }

            $exec->bindValue(1, $this->nome);
            $exec->bindValue(2, $this->duracao);

            return $exec->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }
    public function excluirArquivos() {
        $this->control = new Controles();
        return $this->control->excluirArquivo($this->caminho . $this->imagem, $this->nome);
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
    
    function editarImagem() {
        try {
            $this->con = new Conectar();
            $exec = $this->con->prepare("UPDATE cursos SET imagem = ? WHERE id = ?");
            $exec->bindValue(1, $this->imagem);
            $exec->bindValue(2, $this->id);

            return $exec->execute() == 1 ? TRUE : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }



    function excluir()
    {

        try {
            $this->con = new Conectar();
            $sql = "DELETE FROM cursos WHERE id = ?";
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
            $sql = "SELECT * FROM cursos WHERE nome LIKE ? ORDER BY nome";
            $sql = $this->con->prepare($sql);
            $sql->bindValue(1, $letra . '%');   
 
            return $sql->execute() == 1 ? $sql->fetchAll() : FALSE;
        } catch (PDOException $exc) {
            echo "Erro de bd " . $exc->getMessage();
        }
    }




}