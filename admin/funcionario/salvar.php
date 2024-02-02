<?php
$id = filter_input(INPUT_GET, 'id');
include_once '../class/Funcionario.php';
$cat = new Funcionario(); // esse isset tá sendo usado para caso for editar 
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
        $salario = $dados['salario'];
        $depto = $dados['depto'];
        $imagem = $dados['imagem'];
    } else {
        echo "Registro não existe";
    }
}
?>
<h3>
    <?= isset($id) ? 'editar' : 'cadastrar' ?> funcionario
</h3>
<a class="btn btn-outline-danger float-right" href="?p=funcionario/listar">voltar</a>
<br><br>
<form method="post" enctype="multipart/form-data" name="frmCadastro" id="frmCadastro">

    <div class="form-group">
        <label for="exampleInputText"> nome do funcionario </label>
        <input type="text" class="form-control" id="exampleInputText" name="txtnome"
            value=" <?= isset($id) ? $nome : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText"> salário do funcionario </label>
        <input type="text" class="form-control" id="exampleInputText" name="txtsalario"
            value="<?= isset($id) ? $salario : '' ?>">
    </div>

    <div class="form-group">
        <label for="exampleInputText">Departamento</label>
        <input type="text" class="form-control" id="exampleInputText" name="txtdepto"
            value="<?= isset($id) ? $depto : '' ?>">
    </div>
    <div class="form-group">
        <label for="exampleInputText">Imagem</label>
        <input type="file" class="form-control" id="exampleInputText" name="file_imagem">
    </div>

    <input type="submit" class="btn btn-<?= isset($id) ? 'success' : 'primary' ?> "
        name="<?= isset($id) ? 'btneditar' : 'btnsalvar' ?>" value="<?= isset($id) ? 'editar' : 'salvar' ?>">

</form>
<?php
if (filter_input(INPUT_POST, 'btnsalvar')) { // se o botão salvar for clicado 
    $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
    $salario = filter_input(INPUT_POST, 'txtsalario', FILTER_SANITIZE_STRING);
    $depto = filter_input(INPUT_POST, 'txtdepto', FILTER_SANITIZE_STRING);
    $imagem = $_FILES['file_imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    $dados = array(
        'nome' => $nome,
        'salario' => $salario,
        'depto' => $depto,
        'imagem' => $imagem['name']
    );

    if (strstr('png', $extensao) || strstr('jpeg', $extensao) || strstr('jpg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setNome($nome);
        $cat->setNome(mb_strtoupper($nome, 'UTF-8'));
        $cat->setSalario($salario);
        $cat->setDepto($depto);
        $cat->setDadosJson(json_encode($dados));

        $msg = $cat->salvarFirebase() === true ? 'Erro' : 'Salvo';

        echo '<div class="alert alert-primary mt-3" role="alert">'
            . $msg
            . '</div>';



    }







}
if (filter_input(INPUT_POST, 'btneditar')) { /// se o botão editar for clicado.. 
    $nome = filter_input(INPUT_POST, 'txtnome');
    $salario = filter_input(INPUT_POST, 'txtsalario');
    $depto = filter_input(INPUT_POST, 'txtdepto');
    $imagem = $_FILES['file_imagem'];
    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));


    if (strstr('png', $extensao) || strstr('jpeg', $extensao) || strstr('jpg', $extensao)) {
        $novoNome = sha1(uniqid(time())) . "." . $extensao;
        $cat->setId($id);
        $cat->setImagem($novoNome);
        $cat->setTemp_imagem($imagem['tmp_name']);
        $cat->enviarArquivos();
        $cat->setNome($nome);
        $cat->setNome(mb_strtoupper($nome, 'UTF-8'));
        $cat->setSalario($salario);
        $cat->setDepto($depto);
        $cat->setDadosJson(json_encode($dados));
        $dados = array(
            'nome' => $nome,
            'salario' => $salario,
            'depto' => $depto,
            'imagem' => $imagem['name']
        );
        $cat->setDadosJson(json_encode($dados));

        $msg = $cat->editarFirebase($id) === true ? 'Erro' : 'Editado com sucesso';

        echo '<div class="alert alert-primary mt-3" role="alert">'
            . $msg
            . '</div>';



    }




}