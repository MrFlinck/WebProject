<!--admin/categoria/salvar.php-->
<?php

// capturar o id da URL
  //comunicação com class Categoria
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Professor.php';
$cat = new Professor();
// iiset seve para verificar se a variavel foi utilizada para editar ou salvar 
if(isset($id)){
$cat -> setId($id);
$dados = $cat-> consultarPorID();
foreach ($dados as $mostrar){
    $nome = $mostrar['nome']; // pode ser $descricao = $mostrar[1];
    $email = $mostrar['email']; // pode ser $ramal = $mostrar[2];
    $area = $mostrar['area'];
}
}
// input get singnifica que você está buscando algo 

?>
<h3><?= isset($id) ? 'Editar' : 'Cadastrar' ?> Professor</h3>
<a class="btn btn-outline-danger float-right" href="?p=professor/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">


    <div class="form-group">
        <label for="exampleInputText">Nome do professor</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtnome" value = "<?= isset($id) ? $nome : ''?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">Email do professor</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtemail" value = "<?= isset($id) ? $email : ''?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">area do professor</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtarea" value = "<?= isset($id) ? $area : ''?>">
    </div>
      <div class="form-group">
        <label for="exampleInputText">imagem do professor </label>
        <input type="text" class="form-control" id="exampleInputText" name="txtarea" value = "<?= isset($id) ? $imagem : ''?>">
    </div>

    

    <input type="submit" 
     class="btn btn-<?= isset($id) ? 'success' : 'primary'?>"
     name= "<?= isset($id) ? 'btneditar' : 'btnsalvar'?>"  
     value = "<?= isset($id) ? 'Editar' : 'Cadastrar'?>">
</form>
<?php
//se eu clicar no botão salvar
if (filter_input(INPUT_POST, 'btnsalvar')) {
    //capturei dados do form HTML para variáveis
    $id = filter_input(INPUT_POST, 'txtid');
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);
    $area = filter_input(INPUT_POST, 'txtarea', FILTER_SANITIZE_STRING);


    //enviar dados que capturei do form para class Categoria
    $cat->setId($id);
    $cat->setNome($nome);
    $cat->setEmail($email);
    $cat->setArea($area);

    //efetivar o cadastro
    if($cat->salvar()){
        echo '<div class="alert alert-primary mt-3"
         role="alert">" ';
         echo 'Cadastro efetuado com sucesso';
         echo '</div>';
         echo '<meta http-equiv="refresh" 
         content="0.5"
         URL=?p=professor/listar">';
}
    
    }


if (filter_input(INPUT_POST, 'btneditar')) {
    //capturei dados do form HTML para variáveis
    $id = filter_input(INPUT_POST, 'txtid');
    $nome = filter_input(INPUT_POST, 'txtnome');
    $email = filter_input(INPUT_POST, 'txtemail');
    $area = filter_input(INPUT_POST, 'txtarea');

    //enviar dados que capturei do form para class Categoria
    $cat->setId($id);
    $cat->setNome($nome);
    $cat->setEmail($email);
    $cat->setArea($area);

    //efetivar o cadastro
    if($cat->editar()){
        echo '<div class="alert alert-primary mt-3"
         role="alert"> ';
         echo 'Edição efetuado com sucesso';
         echo '</div>';
         echo '<meta http-equiv="refresh" content="0.5"
         URL=?p=professor/listar">';
}}