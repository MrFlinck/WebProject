<?php
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Aluno.php';
$cat = new Aluno(); // esse isset tá sendo usado para caso for editar 
/*
if (isset($id)) {
    $cat->setid($id);
    $dados = $cat->consultarPorId(); // ele pega os dados do id, já que está chamando a função e mostra
    foreach ($dados as $mostrar) {
        $id = $mostrar['id'];
        $nome = $mostrar['nome'];
        $salario = $mostrar['salario'];
        $depto = $mostrar['depto'];
        $imagem = $mostrar['imagem']; 

    }
}*/
if (isset($id)) {
    $dados = $cat->consultarPorIDFirebase($id);
    if ($dados !== null) {
        $nome = $dados['nome'];
        $email = $dados['email'];
        $telefone = $dados['telefone'];
    } else {
        echo "Registro não existe";
    }
}
?>
<h3>
    <?= isset($id) ? 'editar' : 'cadastrar' ?> aluno
</h3>
<a class="btn btn-outline-danger float-right" href="?p=aluno/listar">voltar</a>
<br><br>
<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">

    <div class="form-group">
        <label for="exampleInputText"> nome do aluno </label>
        <input type="text" class="form-control" id="exampleInputText" name="txtnome"
            value=" <?= isset($id) ? $nome : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText"> email do aluno </label>
        <input type="text" class="form-control" id="exampleInputText" name="txtemail"
            value="<?= isset($id) ? $email : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">telefone do aluno</label>
        <input type="text" class="form-control" id="exampleInputText" name="txttelefone"
            value="<?= isset($id) ? $telefone : '' ?>">
    </div>


    <input type="submit" class="btn btn-<?= isset($id) ? 'success' : 'primary' ?> "
        name="<?= isset($id) ? 'btneditar' : 'btnsalvar' ?>" value="<?= isset($id) ? 'editar' : 'salvar' ?>">

</form>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) { // se o botão salvar for clicado 
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'txttelefone', FILTER_SANITIZE_STRING);
    $dados = array(
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
    );

    $cat->setEmail($email);
    $cat->setTelefone($telefone);
    $cat->setNome(mb_strtoupper($nome, 'UTF-8'));
    $cat->setDadosJson(json_encode($dados));
    $msg = $cat->salvarFirebase() === true ? 'Erro' : 'Salvo';
    if ($msg == 'Salvo com sucesso') {
        echo '<div class="alert alert-primary mt-3"
            role="alert"> ';
        echo 'Edição efetuado com sucesso';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
            URL=?p=categoria/listar">';
    }

    echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';



}

if (filter_input(INPUT_POST, 'btneditar')) { /// se o botão editar for clicado.. 
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'txttelefone', FILTER_SANITIZE_STRING);
    $dados = array(
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
    );

    $cat->setEmail($email);
    $cat->setTelefone($telefone);
    $cat->setNome(mb_strtoupper($nome, 'UTF-8'));
    $cat->setDadosJson(json_encode($dados));
    $msg = $cat->editarFirebase($id) === true ? 'Erro' : 'Editado com sucesso';
    if ($msg == 'Editado com sucesso') {
        echo '<div class="alert alert-primary mt-3"
            role="alert"> ';
        echo 'Edição efetuado com sucesso';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="0.5"
            URL=?p=categoria/listar">';
    }

    echo '<div class="alert alert-primary mt-3" role="alert">'
        . $msg
        . '</div>';


}