<?php 
/*
$array = ['nome' => 'helena', 'idade' => 5];
$nome = $array['nome'];
$idade = $array['idade'];
if($idade > 18){
    echo "$nome é maior de idade.";
}*/
class pessoa{
    public $nome;
    public $idade; 
    function falar($nome, $idade){
        echo "ola! meu nome é $nome e tenho $idade ";
    }
}

$jorge = new pessoa(); 
$jorge -> nome = "jorge";
$jorge -> idade = 18; 
$nome = $jorge -> nome;
$idade = $jorge -> idade; 
echo $jorge -> falar($nome, $idade); 


