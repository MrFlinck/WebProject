<?php
include_once 'Conectar.php';
include_once 'Controles.php';
class Aluno
{
    private $firebaseURL = 'https://app3ds-turmab-default-rtdb.firebaseio.com/';
    private $dadosJson;
    private $id;
    private $nome;
    private $email;
    private $telefone;


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
    function getEmail()
    {
        return $this->email;
    }
    function setEmail($email)
    {
        $this->email = $email;
    }
    function getTelefone()
    {
        return $this->telefone;
    }
    function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }
    public function getDadosJson()
    {
        return $this->dadosJson;
    }
    public function setDadosJson($dadosJson)
    {
        $this->dadosJson = $dadosJson;
    }



    function salvarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'aluno.json');

        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($tabela, CURLOPT_POSTFIELDS, $this->dadosJson);
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }

    function listarFirebase()
    {
        $tabela = curl_init($this->firebaseURL . 'aluno.json');

        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);

        $resposta = curl_exec($tabela);
        curl_close($tabela);

        return $dados = json_decode($resposta, true);
    }
    public function excluirFirebase($key)
    {
        $chave = 'aluno/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $resposta;
    }
    public function editarFirebase($key)
    {
        $chave = 'aluno/' . $key;
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
        $chave = 'aluno/' . $key;
        $tabela = curl_init($this->firebaseURL . $chave . '.json');
        curl_setopt($tabela, CURLOPT_RETURNTRANSFER, true);
        $resposta = curl_exec($tabela);
        curl_close($tabela);
        return $dados = json_decode($resposta, true);
    }

}