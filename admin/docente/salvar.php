<?php
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Docente.php';
$cat = new Docente();
// iiset seve para verificar se a variavel foi utilizada para editar ou salvar 
if (isset($id)) {
    $cat->setId($id);
    $dados = $cat->consultarPorID();
    foreach ($dados as $mostrar) {
        $nome = $mostrar['nome']; // pode ser $descricao = $mostrar[1];
        $nome = $mostrar['email']; // pode ser $descricao = $mostrar[1];
        $nome = $mostrar['formacao']; // pode ser $descricao = $mostrar[1];

    }
}
?>

<h3>
    <?= isset($id) ? 'Editar' : 'Cadastrar' ?> docentes
</h3>
<a class="btn btn-outline-danger float-right" href="?p=docente/listar">Voltar</a>
<br><br>

<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">

    <div class="form-group">
        <label for="exampleInputText">Nome</label>
        <input type="text" class="form-control" id="exampleInputText" placeholder="Informe o nome da área"
            name="txtnome" value="<?= isset($id) ? $nome : '' ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputText">Email</label>
        <input type="text" class="form-control" id="exampleInputText" placeholder="Informe o email"
            name="txtemail" value="<?= isset($id) ? $email : '' ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputText">Formação</label>
        <input type="text" class="form-control" id="exampleInputText" placeholder="Informe a formação"
            name="txtformacao" value="<?= isset($id) ? $formacao : '' ?>">
    </div>


    <input type="submit" class="btn btn-<?= isset($id) ? 'success' : 'primary' ?>"
        name="<?= isset($id) ? 'btneditar' : 'btnsalvar' ?>" value="<?= isset($id) ? 'Editar' : 'Cadastrar' ?>">

</form>
<?php
//se eu clicar no botão salvar
if (filter_input(INPUT_POST, 'btnsalvar')) {
    $nome = filter_input(INPUT_POST, 'txtnome');
    $email = filter_input(INPUT_POST, 'txtemail');
    $formacao = filter_input(INPUT_POST, 'txtformacao');
    $cat->setNome($nome);
    $cat->setEmail($email);
    $cat->setFormacao($formacao);
    $dados = array(
        'nome' => $nome,
        'email' => $email,
        'formacao' => $formacao
    );

    $cat->setDadosJson(json_encode($dados));

    $msg = $cat->salvarFirebase() === true ? 'Erro' : 'Salvo';

    echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>'; 


    

    //efetivar o cadastro
    if($cat->salvar()){
        echo '<div class="alert alert-primary mt-3"
         role="alert"> ';
         echo 'Cadastro efetuado com sucesso';
         echo '</div>';
         echo '<meta http-equiv="refresh" content="0.5"
         URL=?p=docente/listar">';

    }
}
if (filter_input(INPUT_POST, 'btneditar')) { /// se o botão editar for clicado.. 
 
    $nome = filter_input(INPUT_POST, 'txtnome');
    $email = filter_input(INPUT_POST, 'txtemail');
    $idade = filter_input(INPUT_POST, 'txtformacao');
    $cat->setNome($nome);
    $cat->setEmail($email);
    $cat->setFormacao($formacao);
    



    if ($cat->editar()) {
        echo '<div class="alert alert-primary mt-3" role="alert">';
        echo 'edição efetuado com sucesso!';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="1;URL=?p=docente/listar"> ';
    }

}